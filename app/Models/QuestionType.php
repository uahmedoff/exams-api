<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    protected $table = 'question_types';

    protected $fillable = [
        'name',
    ];

    public function questions(){
        return $this->hasMany(Question::class,'type_id','id');
    }

    public function resource_types(){
        return $this->belongsToMany(ResourceType::class,'question_resource_types','question_type_id','resource_type_id');
    }
}
