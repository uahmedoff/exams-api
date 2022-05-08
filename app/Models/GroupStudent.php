<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupStudent extends Model{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'group_students';

    protected $fillable = [
        'supervisor_group_id',
        'student'
    ];

    public function supervisor_group(){
        return $this->belongsTo(SupervisorGroup::class);
    }
}
