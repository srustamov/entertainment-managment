<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use App\Models\Activity;
use Illuminate\Validation\Rule;

class ActivityCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string','min:3',Rule::unique(Activity::class,'name')],
        ];
    }
}
