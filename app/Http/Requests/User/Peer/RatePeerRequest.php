<?php

namespace App\Http\Requests\User\Peer;

use Illuminate\Foundation\Http\FormRequest;

class RatePeerRequest extends FormRequest
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
            'easyWork' => ['required','integer','between:1,5',],
            'workAgain' => ['required','integer','between:0,1',],
            'dependableWork' => ['required','nullable','integer','between:1,5',],
            'communicateUnderPressure' => ['required','integer','between:1,5',],
            'meetDeadline' => ['required','integer','between:1,5',],
            'receivingFeedback' => ['required','integer','between:1,5',],
            'respectfullOther' => ['required','integer','between:1,5',],
            'assistOther' => ['required','integer','between:1,5',],
            'collaborateTeam' => ['required','integer','between:1,5',],
            'experience' => 'required|string',
        ];
    }
}
