<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $category
 */
class UpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'site_title' => [
                'required',
                'string',
                'max:255',
            ],
            'site_icon' => [
                'required',
                'string',
                'max:255',
            ],
            'site_url' => [
                'required',
                'string',
                'max:255',
            ],
            'admin_email' => [
                'required',
                'string',
                'max:255',
            ],
            'registration' => [
                'required',
                'string',
                'max:255',
            ],
            'default_role' => [
                'required',
                'string',
                'max:255',
            ],
            'language' => [
                'required',
                'string',
                'max:255',
            ],
            'timezone' => [
                'required',
                'string',
                'max:255',
            ],
            'date_format' => [
                'required',
                'string',
                'max:255',
            ],
            'time_format' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
