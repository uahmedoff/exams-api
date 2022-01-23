<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'question' => $this->question,
            'type_id' => $this->type_id,
            'is_active' => $this->is_active,
            'level_id' => $this->level_id,
            'category_id' => $this->category_id,
            'resource_id' => $this->resource_id,
            'level' => new LevelResource($this->level),
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
