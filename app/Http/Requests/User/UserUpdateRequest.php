<?php

namespace App\Http\Requests\User;

class UserUpdateRequest extends BaseUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:users,email,' . $this->id,
            'password' => 'sometimes|min:8|confirmed',
            'admin' => 'sometimes|in:0,1',
        ];
    }
}
