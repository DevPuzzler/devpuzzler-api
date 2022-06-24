<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            User::COLUMN_EMAIL => 'required|email',
            User::COLUMN_PASSWORD => 'required|string'
        ];
    }
}
