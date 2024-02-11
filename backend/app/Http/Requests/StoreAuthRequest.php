<?php

namespace App\Http\Requests;

class StoreAuthRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ];
    }
}
