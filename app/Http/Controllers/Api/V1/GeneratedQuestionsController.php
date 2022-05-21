<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Question;
use App\Models\GroupStudent;
use Illuminate\Http\Request;
use App\Models\SupervisorGroup;
use App\Models\GeneratedQuestion;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

class GeneratedQuestionsController extends Controller{
    
    public function examgroups($branch_id,$exam_date){
        if(auth()->user()->role != User::ROLE_ASSESSER)
            return response()->json(['message'=>'You have no permission'],403);  

        $supervisor_groups = SupervisorGroup::where([
            'exam_date' => $exam_date,
            'branch_id' => $branch_id
        ])
        ->withCount(['generated_questions'])
        ->get();
        if(count($supervisor_groups))
            return $supervisor_groups;
        
        try{
            $client = new \GuzzleHttp\Client(['base_uri' => config('app.cb_url')."/api/"]);
            $res = $client->request('GET',"supervisor/exam-groups/branch/".$branch_id."/exam-date/".$exam_date, [
                'headers' => [
                    'Referer' => config('app.cb_url'),
                    "Accept" => 'Application/json',
                    "Authorization" => 'bearer ' . auth()->user()->crm_token,
                ]
            ]);
            $body = json_decode($res->getBody()); // 200
            foreach($body->data as $group){
                $exam_exists = SupervisorGroup::where('group->id',$group->group->id)
                ->where([
                    'level' => $group->level,
                    'exam_date' => $group->exam_date,
                    'branch_id' => $branch_id
                ])->count();
                if(!$exam_exists){
                    $supervisor_group = SupervisorGroup::create([
                        'group' => $group->group,
                        'level' => $group->level,
                        'exam_date' => $group->exam_date,
                        'supervisor_id' => $group->supervisor_id,
                        'branch_id' => $branch_id
                    ]);
                    foreach($group->students as $student){
                        GroupStudent::create([
                            'supervisor_group_id' => $supervisor_group->id,
                            'student' => $student->name
                        ]);
                    }
                }
            }
            return SupervisorGroup::where([
                    'exam_date' => $exam_date,
                    'branch_id' => $branch_id
                ])
                ->withCount(['generated_questions'])
                ->get();
        }
        catch (ClientException $e) {
            // return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function groups(Request $request){
        if(auth()->user()->role != User::ROLE_SUPERVISOR)
            return response()->json(['message'=>'You have no permission'],403);  

        $request->validate([
            'date' => 'required'
        ]);

        $supervisor_groups = SupervisorGroup::where([
            'created_by' => auth()->user()->id,
            'exam_date' => $request->date
        ])
        ->withCount(['generated_questions'])
        ->get();
        if(count($supervisor_groups))
            return $supervisor_groups;
        
        try{
            $client = new \GuzzleHttp\Client(['base_uri' => config('app.cb_url')."/api/"]);
            $res = $client->request('GET',"supervisor/".auth()->user()->staff_id."/exam-groups/".$request->date, [
                'headers' => [
                    'Referer' => config('app.cb_url'),
                    "Accept" => 'Application/json',
                    "Authorization" => 'bearer ' . auth()->user()->crm_token,
                ],
            ]);
            $body = json_decode($res->getBody()); // 200
            foreach($body->data as $group){
                $exam_exists = SupervisorGroup::where('group->id',$group->group->id)
                ->where([
                    'level' => $group->level,
                    'exam_date' => $group->exam_date
                ])->count();
                if(!$exam_exists){
                    $supervisor_group = SupervisorGroup::create([
                        'group' => $group->group,
                        'level' => $group->level,
                        'exam_date' => $group->exam_date
                    ]);
                    foreach($group->students as $student){
                        GroupStudent::create([
                            'supervisor_group_id' => $supervisor_group->id,
                            'student' => $student->name
                        ]);
                    }
                }
            }
            return SupervisorGroup::where([
                    'created_by' => auth()->user()->id,
                    'exam_date' => $request->date
                ])
                ->withCount(['generated_questions'])
                ->get();
        }
        catch (ClientException $e) {
            // return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function generate($supervisor_group_id){
        $students = GroupStudent::where('supervisor_group_id',$supervisor_group_id)
            ->with('supervisor_group')
            ->get();
        foreach($students as $student){
            $question = new Question;
            $level = $student->supervisor_group->level;
            switch($level){
                case 'Beginner Mid':{
                    // Grammar
                    $grammar_questions = $question->generate([
                        'level' => $level,
                        'type' => 'grammar',
                        'limit' => 40
                    ]);
                    foreach($grammar_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Vocabulary
                    $vocabulary_questions = $question->generate([
                        'level' => $level,
                        'type' => 'vocabulary',
                        'limit' => 40
                    ]);
                    foreach($vocabulary_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }
                    
                }
                break;
                case 'Beginner Final':{
                    // Reading
                    $reading_questions = $question->generate([
                        'level' => $level,
                        'type' => 'reading',
                        'limit' => 10
                    ]);
                    foreach($reading_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Grammar
                    $grammar_questions = $question->generate([
                        'level' => $level,
                        'type' => 'grammar',
                        'limit' => 20
                    ]);
                    foreach($grammar_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Vocabulary
                    $vocabulary_questions = $question->generate([
                        'level' => $level,
                        'type' => 'vocabulary',
                        'limit' => 20
                    ]);
                    foreach($vocabulary_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Writing
                    $writing_questions = $question->generate([
                        'level' => $level,
                        'type' => 'writing',
                        'limit' => 1
                    ]);
                    foreach($writing_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }
                }
                break;
                default:{
                    // Reading
                    $reading_questions = $question->generate([
                        'level' => $level,
                        'type' => 'reading',
                        'limit' => 5
                    ]);
                    foreach($reading_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Grammar
                    $grammar_questions = $question->generate([
                        'level' => $level,
                        'type' => 'grammar',
                        'limit' => 20
                    ]);
                    foreach($grammar_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Vocabulary
                    $vocabulary_questions = $question->generate([
                        'level' => $level,
                        'type' => 'vocabulary',
                        'limit' => 20
                    ]);
                    foreach($vocabulary_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }

                    // Writing
                    $writing_questions = $question->generate([
                        'level' => $level,
                        'type' => 'writing',
                        'limit' => 1
                    ]);
                    foreach($writing_questions as $question){
                        GeneratedQuestion::create([
                            'group_student_id' => $student->id,
                            'question_id' => $question->id
                        ]);
                    }
                }
                break;
            }
            // Pesentation (speaking)
            $presentation_questions = $question->generate([
                'level' => $level,
                'type' => 'speaking',
                'limit' => 1
            ]);
            foreach($presentation_questions as $question){
                GeneratedQuestion::create([
                    'group_student_id' => $student->id,
                    'question_id' => $question->id
                ]);
            }
        }
        return response()->json(['message'=>'Questions are successfully generated'],200);
    }

    public function get_supervisor_group($supervisor_group_id){
        return SupervisorGroup::where('id',$supervisor_group_id)
            ->with(['generated_questions.question.qresource','generated_questions.question.answers',])
            ->first();
    }
    
    public function get_supervisor_group_students($supervisor_group_id){
        return GroupStudent::where('supervisor_group_id',$supervisor_group_id)->get();
    }

    public function get_supervisor_group_student($group_student_id){
        return GroupStudent::find($group_student_id);
    }

    public function get_generated_question_for_student($group_student_id){
        return GeneratedQuestion::where('group_student_id',$group_student_id)
            ->with(['question.qresource','question.answers' => function($q){
                $q->inRandomOrder();
            }])
            ->get();
    }
}
