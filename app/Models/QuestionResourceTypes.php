<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResourceTypes extends Model
{
    use HasFactory;

    protected $table = 'question_resource_types';

    protected $fillable = [
        'question_type_id',
        'resource_type_id',
    ];

    public function questions(){
        return $this->belongsTo(QuestionType::class,'question_type_id','id');
    }

    public function resources(){
        return $this->belongsTo(ResourceType::class,'resource_type_id','id');
    }
}
