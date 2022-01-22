<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'src' => $this->src,
            'type_id' => $this->type_id,
            'text' => $this->text,
            'is_active' => $this->is_active,
            'level_id' => $this->level_id,
            'level' => new LevelResource($this->level),
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}
