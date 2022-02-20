<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examgroup extends Model{
    use HasFactory;

    const STATUS_STARTED = 1;
    const STATUS_FINISHED = 2;

    protected $table = 'examgroup';

    protected $fillable = [
        'group_id',
        'level_id',
        'deadline',
        'number_of_students',
        'invigilator_id',
        'status'
    ];
}
