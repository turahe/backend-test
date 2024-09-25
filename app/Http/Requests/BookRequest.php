<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'author_id' => 'required|int|exists:authors,id',
        ];
    }

    public function bodyParameters()
    {
        return [

            'title' => [
                'description' => 'The title of the book.',
                'example' => 'My First Book',
            ],
            'description' => [
                'description' => 'description of the book',
            ],
            'publish_date' => [
                'description' => 'Date to be used as the publication date.',
                'example' => '2019-01-21',
            ],
            'author_id' => [
                'description' => 'Author the book belongs to.',
            ],
        ];
    }
}
