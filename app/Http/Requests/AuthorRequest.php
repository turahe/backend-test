<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'name' => 'required|string',
            'bio' => 'required|string',
            'birth_date' => 'required|date',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Name of author',
                'example' => 'John Doe',
            ],
            'bio' => [
                'description' => 'The biography of author',
                'example' => 'He Is ..',
            ],
            'birth_date' => [
                'description' => 'Birth date of author',
                'example' => '1990-01-01',
            ],
        ];
    }
}
