<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'companyname' => 'max:50',
            'email' => 'required|max:50',
            'phone' => 'required|max:50',
            'streetname' => 'required|max:80',
            'housenumber' => 'required|max:15',
            'postalcode' => 'required|max:15',
            'city' => 'required|max:50',
            'country' => 'required|max:50',
            'text' => 'required|max:65535',
        ];
    }
}
