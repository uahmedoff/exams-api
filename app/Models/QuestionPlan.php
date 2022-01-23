<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ScopeTrait;

class QuestionPlan extends Model
{
    use HasFactory, ScopeTrait;

    protected $table = 'question_plans';

    protected $fillable = [
        'resource_id',
        'question_id',
        'level_id',
        'question_type_id',
        'is_active'
    ];

    private $search_columns = [];

    public function qresource(){
        return $this->belongsTo(Resource::class,'resource_id');
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function question_type(){
        return $this->belongsTo(QuestionType::class);
    }
}
