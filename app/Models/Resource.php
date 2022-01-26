<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;

class Resource extends Model
{
    use HasFactory, ScopeTrait, Userstamps;

    protected $fillable = [
        'src',
        'type_id',
        'text',
        'level_id',
        'is_active'
    ];

    private $search_columns = [
        'text'
    ];

    public function scopeFilter($query){
        if ($filter = request('type_id')){
            $query = $query->where('type_id',$filter);
        }
        if ($filter = request('level_id')){
            $query = $query->where('level_id',$filter);
        }
        if ($filter = request('is_active')){
            $query = $query->where('is_active', $filter);
        }
        return $query;
    }

    public function type(){
        return $this->belongsTo(ResourceType::class,'type_id','id');
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
