<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreCompanyReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // harus diubah ke true, agar tidak err 419
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100',
            'website' => 'required|url|max:255',
        ];
    }

    protected function failedValidation($validator)
    {
        throw new ValidationException(
            $validator,
            response()->json($validator->errors(), 422)
        );
    }
}
