<?php

namespace App\Http\Requests\User\Organization;

use Illuminate\Foundation\Http\FormRequest;

class RateOrganizationRequest extends FormRequest
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
            'employeeHappiness' => ['required','integer','between:1,5',],
            'companyCulture' => ['required','integer','between:1,5',],
            'careerDevelopment' => ['required','nullable','integer','between:1,5',],
            'workLifeBalance' => ['required','integer','between:1,5',],
            'compensationBenefit' => ['required','integer','between:1,5',],
            'jobStability' => ['required','integer','between:1,5',],
            'workplaceDEI' => ['required','integer','between:1,5',],
            'companyReputation' => ['required','integer','between:1,5',],
            'workplaceSS' => ['required','integer','between:1,5',],
            'growthFuturePlan' => ['required','integer','between:1,5',],
            'experience' => 'required|string',
        ];
    }
}
