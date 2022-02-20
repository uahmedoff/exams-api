<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Exam;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;
use App\Http\Controllers\Controller;
use App\Models\Examgroup;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function index(){
        //
    }

    public function store(ExamRequest $request){
        $level = Level::where('name',$request->level_name)->first();
        if(!$level)
            abort(403);
        $examgroup = Examgroup::firstOrNew(
            [
                'group_id' => $request->group_id,
                'level_id' => $level->id,
            ]
        );
        $examgroup->number_of_students += 1;
        $examgroup->deadline = Carbon::now()->addMinutes(80)->addHours(12);
        $examgroup->save();
        $exam = Exam::create([
            'student_id' => $request->student_id,
            'level_id' => $level->id,
            'group' => $request->group,
            'examgroup_id' => $examgroup->id
        ]);
        return $exam;
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
