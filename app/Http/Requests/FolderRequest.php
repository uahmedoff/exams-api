<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolderRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'level_id' => 'required|integer',
            'question_type_id' => 'required|integer',
        ];
    }
}
