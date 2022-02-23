<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'student_id' => $this->student_id,
            'level_id' => $this->level_id,
            'examgroup_id' => $this->examgroup_id,
            'group' => $this->group,
            'student' => new StudentResource($this->student),
            'results' => ResultResource::collection($this->results)
        ];
    }
}
