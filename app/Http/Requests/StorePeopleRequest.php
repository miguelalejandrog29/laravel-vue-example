<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeopleRequest extends FormRequest
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
            'dni' => ['required', 'string', 'unique:people,dni'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string']
        ];
    }
}
