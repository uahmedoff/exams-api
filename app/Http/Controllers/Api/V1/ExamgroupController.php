<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Exam;
use App\Models\User;
use App\Models\Examgroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamgroupResource;

class ExamgroupController extends Controller{
    
    public function get_new_examgroups(){
        if(auth()->user()->role == User::ROLE_INVIGILATOR){
            $examgroup = Examgroup::where([
                'invigilator_id' => null,
                'status' => ExamGroup::STATUS_FINISHED
            ])->orderBy('id','asc')->get();
            return ExamgroupResource::collection($examgroup);
        }
        return response()->json(['message'=>'You have no permission'],403);  
    } 

    public function add_to_checking_list($examgroup_id){
        if(auth()->user()->role == User::ROLE_INVIGILATOR){
            Examgroup::find($examgroup_id)
                ->update([
                    'invigilator_id' => auth()->user()->id
                ]);
            return response()->json([],200);    
        }
        return response()->json(['message'=>'You have no permission'],403);  
    }

    public function get_checking_examgroups(){
        if(auth()->user()->role == User::ROLE_INVIGILATOR){
            $examgroup = Examgroup::where([
                'invigilator_id' => auth()->user()->id,
                'status' => ExamGroup::STATUS_FINISHED
            ])->orderBy('id','asc')->get();
            return ExamgroupResource::collection($examgroup);
        }
        return response()->json(['message'=>'You have no permission'],403);  
    } 

    public function get_exams_by_examgroup($examgroup_id){
        if(auth()->user()->role == User::ROLE_INVIGILATOR){
            $exams = Exam::where('examgroup_id',$examgroup_id)
                ->with(['results' => function($q){
                    $q->whereNotNull('file');
                }])->get();
            return ExamResource::collection($exams);
        }
        return response()->json(['message'=>'You have no permission'],403);  
    }
}
