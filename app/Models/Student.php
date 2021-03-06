<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'date_of_birth',
        'group_id',
        'group',
        'branch_name',
        'current_level'
    ];

    public function exams(){
        return $this->hasMany('exams');
    }
}
