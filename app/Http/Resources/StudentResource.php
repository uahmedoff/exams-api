<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'group_id' => $this->group_id,
            'group' => $this->group,
            'current_level' => $this->current_level,
            'branch_name' => $this->branch_name,
        ];
    }
}
