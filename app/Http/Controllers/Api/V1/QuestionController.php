<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Question;
use App\Models\QuestionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionWithResourceResource;

class QuestionController extends Controller
{
    protected $question;

    public function __construct(Question $question){
        $this->question = $question;
        parent::__construct();
    }

    public function index(Request $request){
        // DB::connection()->enableQueryLog();
        $questions = $this->question->notDeleted();
        $questions = $questions->filter();
        $questions = ($request->order == 'rand') ? $questions->inRandomOrder() : $questions->sort();
        if($request->has('limit')){
            $limit = $request->limit;
            $questions = $questions->limit($limit)->with([
                'qresource',
                'answers' => function($q){
                    $q->inRandomOrder();
                }
            ])->get();
            // return DB::getQueryLog(); 
            return QuestionWithResourceResource::collection($questions);
        }
        else{
            $questions = $questions->paginate($this->per_page);
        }
        return QuestionResource::collection($questions);    
    }

    public function store(QuestionRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question = $this->question->create([
                'question' => $request->question,
                'level_id' => $request->level_id,
                'category_id' => $request->category_id,
                'resource_id' => $request->resource_id,
                'type_id' => $request->type_id,
            ]);
            if($request->has('qp_id')){
                QuestionPlan::find($request->qp_id)
                    ->update([
                        'question_id' => $question->id
                    ]);
            }
            return new QuestionResource($question);
        }        
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function show($id){
        $question = $this->question->findOrFail($id);
        return new QuestionResource($question);
    }

    public function update(Request $request, $id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question = $this->question->findOrFail($id);
            
            if($request->has('question')){
                $question->question = $request->question; 
            }
            if($request->has('level_id')){
                $question->level_id = $request->level_id; 
            }
            if($request->has('resource_id')){
                $question->resource_id = $request->resource_id; 
            }
            if($request->has('category_id')){
                $question->category_id = $request->category_id; 
            }
            if($request->has('type_id')){
                $question->type_id = $request->type_id; 
            }
    
            $question->save();

            return new QuestionResource($question);
        }        
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function destroy($id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question = $this->question->findOrFail($id);
            $question->is_active = !$question->is_active;
            $question->save();
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
