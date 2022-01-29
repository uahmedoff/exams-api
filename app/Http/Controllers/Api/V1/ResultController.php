<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Point;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Models\Question;

class ResultController extends Controller
{
    public function index()
    {
        //
    }

    public function store(ResultRequest $request)
    {   
        for($i=0;$i<count($request->question_answers);$i++){
            if($request->question_answers[$i]){
                $qa = explode("_",$request->question_answers[$i]);
                $qu = Question::where('id',$qa[0])->with('type')->first();
                Result::updateOrCreate(
                    [
                        'exam_id' => $request->exam_id,
                        'question_id' => $qa[0],
                    ],
                    [
                        'answer_id' => $qa[1],
                        'is_correct' => ($qa[3] == 'true') ? 1 : 0,
                        'answer' => $qa[2],
                        'score' => Point::get($request->level,$qu->type->name,$qa[3])
                    ]
                );
            }
        }
        return response()->json(['message'=>'saved'],200);
    }

    public function show($id)
    {
        //
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
