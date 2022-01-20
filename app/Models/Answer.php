<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Traits\ScopeTrait;

class Answer extends Model
{
    use HasFactory, Userstamps, ScopeTrait;
    
    protected $fillable = [
        'answer',
        'question_id',
        'is_correct',
        'is_active'
    ];

    private $search_columns = [
        'answer'
    ];

    public function scopeFilter($query){
        if ($filter = request('answer')){
            $query = $query->where('answer','ilike','%' .  $filter . '%');
        }
        if ($filter = request('question_id')){
            $query = $query->where('question_id', $filter);
        }
        if ($filter = request('is_correct')){
            $query = $query->where('is_correct', $filter);
        }
        if ($filter = request('is_active')){
            $query = $query->where('is_active', $filter);
        }
        return $query;
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
