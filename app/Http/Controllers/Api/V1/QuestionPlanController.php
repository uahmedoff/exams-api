<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\QuestionPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionPlanRequest;
use App\Http\Resources\QuestionPlanResource;

class QuestionPlanController extends Controller
{
    protected $question_plan;

    public function __construct(QuestionPlan $question_plan){
        $this->question_plan = $question_plan;
        parent::__construct();
    }

    public function index(QuestionPlanRequest $request){
        $question_plans = $this->question_plan->where([
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ])
            ->notDeleted()
            ->with('question.answers')
            ->sort()->paginate($this->per_page);
        return QuestionPlanResource::collection($question_plans);
    }

    public function store(QuestionPlanRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question_plan = $this->question_plan->create([
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ]);
            return new QuestionPlanResource($question_plan);
        }
        return response()->json(['message'=>'You have no permission'],403);
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

    public function destroy($id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question_plan = $this->question_plan->findOrFail($id);
            $question_plan->is_active = !$question_plan->is_active;
            $question_plan->save();
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
