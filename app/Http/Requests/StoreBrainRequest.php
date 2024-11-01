<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ja_name' => 'required|string|max:30',
            'en_name' => 'required|string|max:30',
            'ja_description' => 'required|string|max:255',
            'en_description' => 'required|string|max:255',
            'created_by' => 'nullable|string|max:30',
        ];
    }
}
