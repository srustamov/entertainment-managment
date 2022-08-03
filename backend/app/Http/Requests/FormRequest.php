<?php

namespace App\Http\Requests;

/**
 * @method getFilters()
 */
class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }


    public function withDto($dto)
    {
        foreach ($this->validated() as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }

    public function getDto()
    {
        $dto =  new \stdClass();

        foreach ($this->validated() as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }
}
