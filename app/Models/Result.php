<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'answer_id',
        'correct_answer_id',
        'file',
        'answer',
        'score',
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function answer(){
        return $this->belongsTo(Answer::class);
    }

    public function correct_answer(){
        return $this->belongsTo(Answer::class);
    }
}
