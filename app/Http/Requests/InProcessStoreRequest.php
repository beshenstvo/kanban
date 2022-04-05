<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InProcessStoreRequest extends FormRequest
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
            'responsible' => 'required|string',
            'tasks_id' => 'required|integer'
        ];
    }
}
