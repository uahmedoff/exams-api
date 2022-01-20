<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;

class Resource extends Model
{
    use HasFactory, ScopeTrait, Userstamps;

    const TYPE_VIDEO = 1;
    const TYPE_AUDIO = 2;
    const TYPE_IMAGE = 3;
    const TYPE_TEXT = 4;

    protected $fillable = [
        'src',
        'type',
        'text',
        'level_id',
        'is_active'
    ];

    private $search_columns = [
        'text'
    ];

    public function scopeFilter($query){
        if ($filter = request('type')){
            $query = $query->where('type',$filter);
        }
        if ($filter = request('level_id')){
            $query = $query->where('level_id',$filter);
        }
        if ($filter = request('is_active')){
            $query = $query->where('is_active', $filter);
        }
        return $query;
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
