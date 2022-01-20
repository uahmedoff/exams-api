<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionDetailsController extends Controller{
    
    protected $question;

    public function __construct(Question $question){
        $this->question = $question;
        parent::__construct();
    }

    public function number_of_questions(){
        return response()->json([
            "data" => $this->question->numberOfQuestions()
        ],200);
    }
}
