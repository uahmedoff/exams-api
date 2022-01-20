<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceWithoutQuestionsResource extends JsonResource
{
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'src' => $this->src,
            'type' => $this->type,
            'text' => $this->text,
            'is_active' => $this->is_active,
            'level' => new LevelResource($this->level)
        ];
    }
}
