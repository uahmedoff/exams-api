<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    use HasFactory;

    protected $table = 'resource_types';

    protected $fillable = [
        'name',
    ];

    public function resources(){
        return $this->hasMany(Resource::class,'type_id','id');
    }

    public function question_types(){
        return $this->belongsToMany(QuestionType::class,'question_resource_types','resource_type_id','question_type_id');
    }
}
