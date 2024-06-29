<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewReportRequest extends FormRequest
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
            'reservation_id' => 'required|integer|exists:reservations,id',
            'reson' => 'required|in:Cancellation of reservation for an unknown reason,Poor behavior of the staff in the hall,Requesting additional fees inside the hall,Manipulating the end date of the ceremony,other reasons'
        ];
    }
}
