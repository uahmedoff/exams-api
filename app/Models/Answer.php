<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Traits\ScopeTrait;

class Answer extends Model
{
    use HasFactory, Userstamps, ScopeTrait;
    
    const TYPE_GAP_FILLING = 1;
    const TYPE_MULTIPLE_CHOICE = 2;
    const TYPE_CHOOSE_CORRECT_OPTION = 3;
    const TYPE_WRITE_THE_MISSING_LETTERS = 4;
    const TYPE_FILL_GAPS_WITH_GIVEN_WORDS = 5;
    const TYPE_MATCH_QUESTIONS = 6;
    const TYPE_COMPLETE_THE_SENTENCES_WITH_ARTICLES = 7;
    const TYPE_COMPLETE_THE_SENTENCES_WITH_CORRECT_VERBS = 8;

    protected $fillable = [
        'answer',
        'question_id',
        'is_correct',
        'is_active',
        'type_id'
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
        if ($filter = request('type_id')){
            $query = $query->where('type_id', $filter);
        }
        return $query;
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
