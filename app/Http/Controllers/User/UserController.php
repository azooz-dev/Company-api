<?php

namespace App\Http\Controllers\User;

use App\Events\UserCreated;
use App\Http\Controllers\ApiController;
use App\Mail\ResendEmailVerification;
use App\Models\User;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        $this->middleware('auth:api')->except(['store', 'verify', 'resendEmail']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateTokenString();

        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        event(new UserCreated($user));

        return $this->showOne($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->showOne($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:8|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $request->email != $user->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateTokenString();
            $user->email = $data['email'];
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field.', 409);
            }

            $user->admin = $data['admin'];
        }

        if ($request->has('password')) {
            $user->password = Hash::make($data['password']);
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update.', 422);
        }

        $user->save();

        return $this->showOne($user, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user, 200);
    }

    public function verify(string $token) {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been successfully verified.', 200);
    }

    public function resendEmail(User $user) {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified.', 409);
        }

        Mail::to($user->email)->queue(new ResendEmailVerification($user));

        return $this->showMessage('The verification email has been resend.', 200);
    }
}
