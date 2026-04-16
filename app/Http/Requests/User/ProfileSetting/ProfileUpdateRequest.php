<?php

namespace App\Http\Requests\User\ProfileSetting;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => [ 'required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/' ],
            'lastName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'organization' => 'required',
            'department' => 'required',
            'jobTitle' => 'required|string|max:255',
            'fileUpload' => 'sometimes|file|mimes:svg,png,jpg,gif',
        ];
    }
}
