<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DressUpdateRequest extends FormRequest
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
            'gender'=>'in:male,female',
            'dresstype'=>'in:Wedding Dress,Evening Dress,Suit',
            'size'=>'in:Small,Medium,Large,XLarge,XXLarge',
            'price'=>'integer',
            'number'=>'integer'
        ];
    }
}
