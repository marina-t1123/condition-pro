<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MEventPosition;
use Illuminate\Validation\Validator;

class SearchAthleteRequest extends FormRequest
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
            'athlete_name' => 'nullable|string|max:255',
            'm_event_id' => 'nullable|integer|exists:m_events,id',
            'm_event_position_id' => 'nullable|integer|exists:m_event_positions,id'
        ];
    }

}
