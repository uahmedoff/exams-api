<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'answer' => $this->answer,
            'question_id' => $this->question_id,
            'is_correct' => $this->is_correct,
            'is_active' => $this->is_active,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
        ];
    }
}
