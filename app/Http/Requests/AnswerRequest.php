<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'answer' => 'required',
            'question_id' => 'required|integer',
            'is_correct' => 'required|boolean'
        ];
    }
}
