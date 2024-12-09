<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleUpdateRequest extends FormRequest
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
            'transporter_id' => 'exists:users,id',
            'license_plate' => 'string|unique:vehicles,license_plate|max:10',
            'transport_type' => 'string|in:truck,car,pick-up,4x4,van,motorcycle',
            'brand' => 'string|max:50',
            'model' => 'string|max:50',
            'year' => 'integer|digits:4|min:1900|max:' . date('Y'),
            'status' => 'string|in:active,inactive,maintenance',
        ];
    }
}
