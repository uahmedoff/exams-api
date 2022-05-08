<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class SupervisorGroup extends Model{
    use HasFactory, Userstamps;

    const UPDATED_AT = null;

    protected $table = 'supervisor_groups';

    protected $fillable = [
        'group',
        'level',
        'exam_date'
    ];

    protected $casts = [
        'group' => 'array'
    ];

    public function setUpdatedByAttribute($value){
        return null;
    }

    public function students(){
        return $this->hasMany(GroupStudent::class);
    }

    public function generated_questions(){
        return $this->hasManyThrough(GeneratedQuestion::class, GroupStudent::class);
    }
}
