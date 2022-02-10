<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Exam;
use App\Helpers\Point;
use App\Models\Result;
use App\Services\File;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;

class ResultController extends Controller
{
    public function index()
    {
        //
    }

    public function store(ResultRequest $request)
    {   
        if($request->image){
            $exam = Exam::find($request->exam_id);
            $fileName = File::uploadFromBase64($request->image,[
                'folder1' => 'student',
                'folder2' => $exam->student->name.'_'.$exam->student->surname.'_'.$exam->student->id
            ]);
            Result::updateOrCreate(
                [
                    'exam_id' => $request->exam_id,
                    'question_id' => $request->question_id,
                ],
                [
                    'file' => $fileName,
                ]
            );
        }
        if(count($request->question_answers)>0){
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
        }
        if(count($request->question_typed_correct_answers)){
            $qtca = $request->question_typed_correct_answers;
            for($i=0;$i<count($qtca);$i++){
                if(array_key_exists($i,$qtca) && $qtca[$i]){
                    // return $qtca[$i];
                    $qu = Question::where('id',$i)->with(['answers','type'])->first();
                    $is_correct = false;
                    foreach($qu->answers as $answer){
                        if($answer->answer == $qtca[$i] && $answer->is_correct == true){
                            $is_correct = true;
                        }
                    }
                    Result::updateOrCreate(
                        [
                            'exam_id' => $request->exam_id,
                            'question_id' => $i,
                        ],
                        [
                            'answer_id' => null,
                            'is_correct' => $is_correct,
                            'answer' => $qtca[$i],
                            'score' => Point::get($request->level,$qu->type->name,$is_correct)
                        ]
                    );
                }
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
