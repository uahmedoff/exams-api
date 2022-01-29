<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'exam_id' => 'required|integer',
            // 'question_id' => 'required|integer',
            'answer_id' => 'nullable|integer',
            'correct_answer_id' => 'nullable|integer',
            'answer' => 'nullable',
        ];
    }
}
