<?php

namespace App\Http\Requests\Api\V1\Slot;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'service_id' => 'required|integer|exists:services,id',
            'starts_at' => 'required|date_format:Y-m-d H:i:s',
            'ends_at' => 'required|date_format:Y-m-d H:i:s|after:starts_at'
        ];
    }
}
