<?php

namespace App\Http\Requests;

use App\Enums\SearchTypeEnum;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'query' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', Rule::in(SearchTypeEnum::cases())],
        ];
    }
}
