<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'level_id',
        'group',
        'examgroup_id'
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

    public function exams_by_groups(){
        $query="select
            distinct e.\"group\",
            e.level_id,
            (
                select count(distinct cer.exam_id) from cb_exams_results cer
                left join cb_exams_exams cee on cer.exam_id=cee.id
                where cee.\"group\" = e.\"group\"
            ) as students_count
        from cb_exams_exams e	
        inner join cb_exams_results r
            on e.id = r.exam_id
        where r.score is null";
        return DB::select($query);
    }
}
