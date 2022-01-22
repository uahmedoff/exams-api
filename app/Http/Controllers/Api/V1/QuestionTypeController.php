<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\QuestionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionTypeResource;

class QuestionTypeController extends Controller
{
    protected $question_type;

    public function __construct(QuestionType $question_type){
        $this->question_type = $question_type;
        parent::__construct();
    }

    public function index(){
        $question_types = $this->question_type->all();
        return QuestionTypeResource::collection($question_types);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id){
        $question_type = $this->question_type->find($id);
        return new QuestionTypeResource($question_type);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
