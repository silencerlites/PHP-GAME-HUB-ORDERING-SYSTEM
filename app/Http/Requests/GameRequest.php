<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'platform' => ['required', 'string', 'max:60'],
            'genre' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock_quantity' => ['required', 'integer', 'min:0', 'max:999999'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'The game cover must be a valid image.',
            'image.mimes' => 'The game cover must be a JPG, JPEG, PNG, or WEBP image.',
            'image.max' => 'The game cover must not be larger than 4 MB.',
        ];
    }
}
