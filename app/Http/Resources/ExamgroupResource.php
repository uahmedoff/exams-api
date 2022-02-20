<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamgroupResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'group_id' => $this->group_id,
            'level_id' => $this->level_id,
            'deadline' => $this->deadline,
            'number_of_students' => $this->number_of_students,
            'invigilator_id' => $this->invigilator_id,
            'status' => $this->status
        ];
    }
}
