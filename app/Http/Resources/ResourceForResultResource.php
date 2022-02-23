<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceForResultResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'src' => $this->src,
            'type' => new ResourceTypeResource($this->type),
            'text' => $this->text,
            'is_active' => $this->is_active,
            'created_by' => new UserResource($this->creator),
            'updated_by' => new UserResource($this->editor),
        ];
    }
}
