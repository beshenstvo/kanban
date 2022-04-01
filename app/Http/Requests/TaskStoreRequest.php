<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
        return [ // названия полей для фронта
            'taskName' => 'required|string|min:2|max:255',
            'description' => 'required',
            'deadline' => 'required|date',
            'user_id' => 'required'//должен быть заполнен на фронте самой программой
        ];
    }
}
