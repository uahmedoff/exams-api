<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'level_id',
        'question_type_id',
        'is_active'
    ];
}
