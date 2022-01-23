<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionPlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
            'resource_id' => $this->resource_id,
            'qresource' => new ResourceResource($this->qresource),
            'question_id' => $this->question_id,
            'question' => new QuestionResource($this->question),
            'level_id' => $this->level_id,
            'question_type_id' => $this->question_type_id,
            'question' => new QuestionResource($this->question),
            'is_active' => $this->is_active
        ];
    }
}
