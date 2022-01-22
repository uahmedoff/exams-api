<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\QuestionPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionPlanRequest;
use App\Http\Resources\QuestionPlanResource;

class QuestionPlanController extends Controller
{
    protected $question;

    public function __construct(QuestionPlan $question_plan){
        $this->question_plan = $question_plan;
        parent::__construct();
    }

    public function index(QuestionPlanRequest $request){
        $question_plans = $this->question_plan->where([
            'level_id' => $request->level_id,
            'question_type_id' => $request->question_type_id,
        ])->with('question.answers')->get();
        return QuestionPlanResource::collection($question_plans);
    }

    public function store(QuestionPlanRequest $request){
        $question_plan = $this->question_plan->create([
            'level_id' => $request->level_id,
            'question_type_id' => $request->question_type_id,
        ]);
        return new QuestionPlanResource($question_plan);
    }

    public function show($id){
        $question_plan = $this->question_plan->where([
            'id' => $id
        ])->with('question.answers')->first();
        return new QuestionPlanResource($question_plan);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
