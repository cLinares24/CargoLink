<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShipmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:users,id',
            'transporter_id' => 'required|exists:users,id',
            'source_address' => 'required|string|max:200',
            'destination_address' => 'required|string|max:200',
            'status' => 'required|string'/*|in:pending,shipped,delivered,canceled'*/,
            'amount' => 'required|numeric|min:0',
            'estimated_delivery' => 'required|date|after_or_equal:created_at',
        ];
    }
}
