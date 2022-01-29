<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Helpers\GroupHelper;
use GuzzleHttp\Exception\ClientException;

class StudentController extends Controller{
    
    public function get_student_by_phone($phone){
        try{
            $client = new \GuzzleHttp\Client(['base_uri' => config('app.cb_url')."/api/"]);
            $res = $client->request('GET','get_student_by_phone/'.$phone, [
                'headers' => [
                    'Referer' => config('app.cb_url'),
                    "Accept" => 'Application/json',
                    "Authorization" => 'bearer ' . auth()->user()->crm_token,
                ],
            ]);
            $body = json_decode($res->getBody()); // 200
        }
        catch (ClientException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $group_helper = new GroupHelper;
        foreach($body->groups as $group){
            if($group->status == 'a' && $group->pivot->status == 'a'){
                $week_num = 0;
                if($group->current_week)
                    $week_num = $group->current_week->week_num;
                $student = Student::updateOrCreate(
                    [
                        'phone' => $body->phone
                    ],
                    [
                        'name' => $body->name,
                        'surname' => $body->surname,
                        'date_of_birth' => $body->date_of_birth,
                        'group' => $group_helper->groupName($group),
                        'current_level' => $group_helper->getStudentExamLevel($group->level->name,$week_num)
                    ]
                );
                return $student;
            }
        }
    }
}
