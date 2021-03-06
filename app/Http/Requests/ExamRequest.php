<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|integer',
            'level_name' => 'required',
            'group' => 'required',
            'group_id' => 'required|integer'
        ];
    }
}
