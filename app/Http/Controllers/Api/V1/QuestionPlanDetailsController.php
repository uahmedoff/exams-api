<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionPlanRequest;
use App\Models\QuestionPlan;
use Illuminate\Http\Request;

class QuestionPlanDetailsController extends Controller{
    
    protected $question_plan;

    public function __construct(QuestionPlan $question_plan){
        $this->question_plan = $question_plan;
        parent::__construct();
    }

    public function number_of_question_plans(QuestionPlanRequest $request){
        $all_question_plans = $this->question_plan->where([
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ])
            ->notDeleted()
            ->count();
        $question_plans_with_inserted_question = $this->question_plan->where([
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ])
            ->notDeleted()
            ->has('question')
            ->count();
        return response()->json([
            'all' => $all_question_plans,
            'with_questions' => $question_plans_with_inserted_question
        ],200);
    }
}
