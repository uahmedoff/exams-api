<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'exam_id' => $this->exam_id,
            'question_id' => $this->question_id,
            'answer_id' => $this->answer_id,
            'is_correct' => $this->is_correct,
            'file' => $this->file,
            'answer' => $this->answer,
            'score' => $this->score,
            'comment' => $this->comment,
            'invigilator_file' => $this->invigilator_file
        ];
    }
}
