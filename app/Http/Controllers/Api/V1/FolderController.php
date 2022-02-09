<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\FolderResource;

class FolderController extends Controller
{
    public function index(FolderRequest $request){
        $folders = Folder::where([
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ])
            ->get();
        return FolderResource::collection($folders);
    }

    public function store(FolderRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $folder = Folder::create([
                'name' => $request->name,
                'level_id' => $request->level_id,
                'question_type_id' => $request->question_type_id,
            ]);
            return new FolderResource($folder);
        }
        return response()->json(['message' => 'You have no permission'],403);
    }

    public function show($id){
        return new FolderResource(Folder::find($id));
    }

    public function update(Request $request, $id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $folder = Folder::find($id);
            if($request->has('name')){
                $folder->name = $request->name;
            }
            if($request->has('level_id')){
                $folder->level_id = $request->level_id;
            }
            if($request->has('question_type_id')){
                $folder->question_type_id = $request->question_type_id;
            }
            $folder->save();
            return new FolderResource($folder);
        }
        return response()->json(['message' => 'You have no permission'],403);    
    }

    public function destroy($id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $question = Folder::findOrFail($id);
            $question->is_active = !$question->is_active;
            $question->save();
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
