<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderResource extends JsonResource
{
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'level_id' => $this->level_id,
            'question_type_id' => $this->question_type_id,
            'is_active' => $this->is_active,
        ];
    }
}
