<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use App\Models\Examgroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamDetailsController extends Controller
{
    public function upload_student_voice(Request $request,$student_id,$exam_id,$question_id){
        $student = Student::find($student_id);
        $imagePath = $request->file('audio')->store('student/'.$student->name.'_'.$student->surname.'_'.$student->id, 'public');
        Result::create([
            'exam_id' => $exam_id,
            'question_id' => $question_id,
            'file' => $imagePath
        ]);
        return response()->json([],200);
    }

    public function clear_results($exam_id){
        Result::where('exam_id',$exam_id)->delete();
        return response()->json([],204);
    }

    public function exams_by_groups(Exam $exam){
        return $exam->exams_by_groups();
    }

    public function set_exam_finished($exam_id){
        $exam = Exam::find($exam_id);
        Examgroup::find($exam->examgroup_id)
            ->update([
                'status' => Examgroup::STATUS_FINISHED        
            ]);
        return response()->json('',200);
    }
}
