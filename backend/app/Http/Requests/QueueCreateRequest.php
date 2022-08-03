<?php

namespace App\Http\Requests;

use App\Models\Queue;
use Illuminate\Validation\Rule;

class QueueCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'queueable_type' => ['required', 'string', Rule::in(Queue::TYPES)],
            'queueable_id' => ['required', 'integer'],
        ];
    }
}
