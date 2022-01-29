<?php
namespace App\Helpers;

class Point{
    public static function get($level_name,$question_type,$is_correct){
        $point = 0;
        if($is_correct == 'true'){
            switch($question_type){
                case 'listening':
                    $point = 1;
                    break;
                case 'grammar':
                    {
                        if($level_name == 'Beginner Mid')
                            $point = 0.625;
                        else
                            $point = 1;    
                    }
                    break;
                case 'vocabulary':
                    {
                        if($level_name == 'Beginner Mid')
                            $point = 0.625;
                        else
                            $point = 1;
                    }
                    break;        
                case 'reading':
                    $point = 1;
                    break;
                case 'speaking':
                    {
                        if($level_name == 'Beginner Mid')
                            $point = 5;
                        else
                            $point = 3.125;
                    }
                    break;
                case 'writing':
                    $point = 25;
                    break;
            }
        }    
        return $point;
    }
}