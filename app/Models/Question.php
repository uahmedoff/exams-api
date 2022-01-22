<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ScopeTrait;
use Illuminate\Support\Facades\DB;
use Wildside\Userstamps\Userstamps;

class Question extends Model
{
    use HasFactory, ScopeTrait, Userstamps;

    protected $fillable = [
        'question',
        'level_id',
        'type_id',
        'resource_id',
        'is_active'
    ];

    private $search_columns = [
        'question'
    ];
    
    public function scopeFilter($query){
        if ($filter = request('without_resource')){
            $query = $query->whereNull('resource_id');
        }
        if ($filter = request('question')){
            $query = $query->where('question','ilike','%' .  $filter . '%');
        }
        if ($filter = request('level_id')){
            $query = $query->whereHas('level',function($q)use($filter){
                $q->where('id',$filter);
            });
        }
        if ($filter = request('type')){
            $query = $query->where('type_id', $filter);
        }
        if ($filter = request('is_active')){
            $query = $query->where('is_active', $filter);
        }
        return $query;
    }

    public function scopeWithoutResource($query){
        return $query->whereNull('resource_id');
    }

    public function type(){
        return $this->belongsTo(QuestionType::class,'type_id','id');
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function qresource(){
        return $this->belongsTo(Resource::class,'resource_id');
    }

    public function numberOfQuestions(){
        $query = 'SELECT "l"."name" as level,
            CASE 
                WHEN "q"."type"=1  THEN \'Listening\'
                WHEN "q"."type"=2  THEN \'Reading\'
                WHEN "q"."type"=3  THEN \'Grammar\'
                WHEN "q"."type"=4  THEN \'Vocabulary\'
                WHEN "q"."type"=5  THEN \'Speaking\'
                WHEN "q"."type"=6  THEN \'Writing\'
            END as "question_type",
            COUNT(q.id) as number_of_questions
            FROM cb_exams_questions q
            LEFT JOIN cb_exams_levels l 
                ON q.level_id = l.id
            WHERE 
                q.is_active = true    
            GROUP BY "q"."type", q.level_id,"l"."name"
            ORDER BY q.level_id, "q"."type"	ASC';
        return DB::select($query);
    }
}
