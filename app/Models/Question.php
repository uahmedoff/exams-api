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

    const CATEGORY_EASY = 1;
    const CATEGORY_MEDIUM = 2;
    const CATEGORY_DIFFICULT = 3;

    protected $fillable = [
        'question',
        'level_id',
        'type_id',
        'category_id',
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
        if ($filter = request('level')){
            $query = $query->whereHas('level',function($q)use($filter){
                $q->where('name',$filter);
            });
        }
        if ($filter = request('type_id')){
            $query = $query->where('type_id', $filter);
        }
        if ($filter = request('is_active')){
            $query = $query->where('is_active', $filter);
        }
        return $query;
    }

    public function scopeNotDeleted($query){
        return $query->where('is_active',true)
            ->whereHas('question_plan',function($q){
                $q->where('is_active',true);
            });
    }

    public function question_plan(){
        return $this->hasOne(QuestionPlan::class);
    }

    public function type(){
        return $this->belongsTo(QuestionType::class,'type_id','id');
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class)
            ->where('is_active',true);
    }

    public function qresource(){
        return $this->belongsTo(Resource::class,'resource_id');
    }

    public function numberOfQuestions(){
        $query = 'SELECT "l"."name" as level,
            qt.name as "question_type",
            COUNT(q.id) as number_of_questions
            FROM cb_exams_questions q
            LEFT JOIN cb_exams_question_plans qp 
                ON qp.question_id = q.id
            LEFT JOIN cb_exams_levels l 
                ON q.level_id = l.id
            LEFT JOIN cb_exams_question_types qt 
                ON qt.id = q.type_id
            WHERE 
                q.is_active = true    
                AND qp.is_active = true
            GROUP BY "q"."type_id", q.level_id,"l"."name",qt.name
            ORDER BY q.level_id, "q"."type_id"	ASC';
        return DB::select($query);
    }

    public function generate($params){
        return self::whereHas('level',function($q)use($params){
            $q->where('name',$params['level']);
        })
        ->whereHas('type',function($q)use($params){
            $q->where('name',$params['type']);
        })
        ->notDeleted()
        ->inRandomOrder()
        ->limit($params['limit'])
        ->get();
    }
}
