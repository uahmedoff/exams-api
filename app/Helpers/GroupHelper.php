<?php
namespace App\Helpers;

class GroupHelper{

    public function groupName($group){
        $days = '';
        switch($group->days){
            case 'mwf':
                $days = "Odd days";
                break;
            case 'tts':
                $days = "Even days";
                break;
            case "ed":
                $days = "Every day";
                break;        
        }
        $teacher = "";
        if(count($group->teachers)){
            $nickname = ($group->teachers[0]->nickname) ? " (" . $group->teachers[0]->nickname .") " : "";
            $teacher = $group->teachers[0]->name . $nickname;
        }
        $time = substr($group->time, 0, -3);
        return $days . " ". $time ." " . $teacher;
    }

    public function getStudentExamLevel($level_name,$week_num){
        if(!$week_num)
            return "Beginner Mid";
        $exam_level = $level_name."";
        switch($level_name){
            case 'Beginner':
            case 'IELTS Rocket':
            case 'Focus':
                {
                    if($week_num <= 4){
                        $exam_level .= " Mid";
                    }
                    elseif($week_num > 4 && $week_num <= 9){
                        $exam_level .= " Final";
                    }
                }
                break;
            case 'IELTS':
                {
                    if($week_num <= 9){
                        $exam_level .= " Mid";
                    }
                    elseif($week_num > 9 && $week_num <= 18){
                        $exam_level .= " Final";
                    }
                }
                break; 
            default: 
                {
                    if($week_num <= 6){
                        $exam_level .= " Mid";
                    }
                    elseif($week_num > 6 && $week_num <= 13){
                        $exam_level .= " Final";
                    }
                }   
                break;    
        }
        $exam_level = explode(" ",$exam_level);
        $exam_level = $exam_level[0]." ".$exam_level[1];
        return $exam_level;
    }
}