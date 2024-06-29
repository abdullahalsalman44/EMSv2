<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalonStorRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:30',
            'capacity' => 'required|integer',
            'pricefortable' => 'required|integer',
            'Adress' => 'required|in:Damascus,Aleppo,Daraa,Der ez-Zor,Homs,Hama',
            'admin_email'=>'required|email|exists:users,email',
            'start'=>'required',
            'end'=>'required'
        ];
    }
}
