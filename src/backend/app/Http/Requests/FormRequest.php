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
    public function authorize()
    {
        return true;
    }
}
