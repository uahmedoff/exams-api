<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswerResource;

class AnswerController extends Controller
{
    protected $answer;

    public function __construct(Answer $answer){
        $this->answer = $answer;
        parent::__construct();
    }

    public function index(){
        $answers = $this->answer->notDeleted();
        $answers = $answers->filter();
        $answers = $answers->sort()->paginate($this->per_page);
        return AnswerResource::collection($answers);    
    }

    public function store(AnswerRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            if($request->is_correct){
                $this->answer->where('question_id',$request->question_id)
                    ->update(['is_correct' => false]);
            }
            $answer = $this->answer->create([
                'answer' => $request->answer,
                'question_id' => $request->question_id,
                'is_correct' => $request->is_correct,
                'type_id' => $request->type_id
            ]);
            return new AnswerResource($answer);
        }        
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function show($id){
        $answer = $this->answer->find($id);
        return new AnswerResource($answer);
    }

    public function update(Request $request, $id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $answer = $this->answer->find($id);
            
            if($request->has('answer')){
                $answer->answer = $request->answer; 
            }
            if($request->has('question_id')){
                $answer->question_id = $request->question_id; 
            }
            if($request->has('is_correct')){
                $answer->is_correct = $request->is_correct; 
            }
            if($request->has('type_id')){
                $answer->type_id = $request->type_id; 
            }
    
            $answer->save();

            return new AnswerResource($answer);
        }        
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function destroy($id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $answer = $this->answer->findOrFail($id);
            $answer->is_active = !$answer->is_active;
            $answer->save();
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
