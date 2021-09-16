<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use App\Models\Activity;
use Illuminate\Validation\Rule;

class ActivityItemCreateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name'        => ['required','string','min:3','max:50'],
            'price'       => ['required','numeric','min:0','not_in:0'],
            'period'      => ['required','numeric','min:0','not_in:0'],
            'activity_id' => ['required',Rule::exists(Activity::class,'id')],
        ];
    }
}
