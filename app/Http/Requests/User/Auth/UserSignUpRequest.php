<?php

namespace App\Http\Requests\User\Auth;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserSignUpRequest extends FormRequest
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
            'fileUpload' => 'file|mimes:svg,png,jpg,gif|max:15360',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        // Get the organization ID from the request
        $organizationId = $this->input('organization');
        if (!($validator->errors()->has('organization'))) {
            // Redirect back to the route with departments in the session if any validation fails validation fails
            $validationDepartments = Department::where('organizationId', $organizationId)->get();
            session()->flash('validationDepartments', $validationDepartments);
            // Handle other validation failures as usual
            throw new ValidationException($validator);
        }

        // Handle other validation failures as usual
        throw new ValidationException($validator);
    }
}
