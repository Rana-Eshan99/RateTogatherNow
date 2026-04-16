<?php

namespace App\Http\Requests\User\Organization;

use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AddOrganizationRequest extends FormRequest
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
            'organizationName' => 'required|string|max:255',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'fileUpload' => 'mimes:png,jpg,jpg,gif',
            'latitude' => 'required',
            'longitude' => 'required',
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
        // Get the countryId from the request
        $countryId = $this->input('countryId');

        // Fetch the states based on the countryId
        $state = State::where('countryId', $countryId)->get();

        // Store the state data in the session
        session()->flash('stateData', $state);

        // Redirect to a specific route on validation failure
        $redirectUrl = route('user.organization.addOrganizationForm');

        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($redirectUrl);
    }
}

