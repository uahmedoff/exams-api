<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;

class Level extends Model
{
    use HasFactory, ScopeTrait, Userstamps;

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function exams(){
        return $this->hasMany('exams');
    }
}
