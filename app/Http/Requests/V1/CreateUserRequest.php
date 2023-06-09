<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array<int,string>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', sprintf('unique:%s', User::class)],
            'password' => ['required', 'min:8'],
        ];
    }
}
