<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'level_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function results(){
        return $this->hasMany(Result::class);
    }
}
