<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionForResultResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_id' => $this->type_id,
            'level_id' => $this->level_id,
            'category_id' => $this->category_id,
            'resource_id' => $this->resource_id,            
            'question' => $this->question,
            'is_active' => $this->is_active,
            // 'category' => $this->category_id,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
            'qresource' => new ResourceForResultResource($this->qresource),
            'level' => new LevelResource($this->level),
            'type' => new QuestionTypeResource($this->type),
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
