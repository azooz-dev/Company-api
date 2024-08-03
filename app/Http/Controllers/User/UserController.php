<?php

namespace App\Http\Controllers\User;

use App\Events\UserCreated;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\ResendEmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api')->except(['store', 'verify', 'resendEmail']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->allowedAdminActions();
        $users = User::all();

        $users = UserResource::collection($users);
        return $this->showAll($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateTokenString();

        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        event(new UserCreated($user));

        $user = new UserResource($user);
        return $this->showOne($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = new UserResource($user);
        return $this->showOne($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->has('name')) {
            $user->name = $data['name'];
        }

        if ($request->has('email') && $data['email'] != $user->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateTokenString();
            $user->email = $data['email'];
        }

        if ($request->has('admin')) {
            $this->allowedAdminActions();
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

        $user = new UserResource($user);
        return $this->showOne($user, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        $user = new UserResource($user);
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
