<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedQuestion extends Model{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'generated_questions';

    protected $fillable = [
        'question_id',
        'group_student_id',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function group_student(){
        return $this->belongsTo(GroupStudent::class);
    }
}
