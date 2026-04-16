<?php

namespace App\Http\Requests\user\Peer;

use App\Enums\GenderEnum;
use App\Models\Department;
use App\Enums\EthnicityEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AddPeerRequest extends FormRequest
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
        // Possible gender
        $genders = [
            GenderEnum::MALE,
            GenderEnum::FEMALE,
            GenderEnum::OTHER,
        ];

        // Possible ethnicity
        $ethnicityStatuses = [
            EthnicityEnum::WHITE,
            EthnicityEnum::BLACK,
            EthnicityEnum::HISPANIC_OR_LATINO,
            EthnicityEnum::MIDDLE_EASTERN,
            EthnicityEnum::AMERICAN_INDIAN_OR_ALASKA_NATIVE,
            EthnicityEnum::ASIAN,
            EthnicityEnum::NATIVE_HAWAIIAN_OR_OTHER_PACIFIC_ISLANDER,
            EthnicityEnum::OTHER,
        ];
        return [
            'firstName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'lastName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'gender' => ['required', Rule::in($genders)],
            'ethnicity' => ['required', Rule::in($ethnicityStatuses)],
            'organizationId' => 'required|exists:organizations,id',
            'departmentId' => 'required|exists:departments,id',
            'jobTitle' => 'required|string|max:255',
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
        $organizationId = $this->input('organizationId');
        if (!($validator->errors()->has('organizationId'))) {
            // Redirect back to the route with departments in the session if any validation fails validation fails
            $departmentData = Department::where('organizationId', $organizationId)->get();
            session()->flash('departmentData', $departmentData);
            // Handle other validation failures as usual
            throw new ValidationException($validator);
        }

        // Handle other validation failures as usual
        throw new ValidationException($validator);
    }
}
