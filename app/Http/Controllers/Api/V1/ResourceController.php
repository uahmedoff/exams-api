<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Services\File;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Level;

class ResourceController extends Controller
{
    protected $resource;

    public function __construct(Resource $resource){
        $this->resource = $resource;
        parent::__construct();
    }

    public function index(){
        $resources = $this->resource->with('questions');
        $resources = $resources->filter();
        $resources = $resources->sort()->paginate($this->per_page);
        return ResourceResource::collection($resources);    
    }

    public function store(ResourceRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $fileName = ($request->src && $request->type) ? File::uploadFromBase64($request->src,[
                'folder1'=>$request->level_id,
                'folder2'=>$request->type
            ]) : null;
            $resource = $this->resource->create([
                'src' => $fileName,
                'type' => $request->type,
                'text' => $request->text,
                'level_id' => $request->level_id
            ]);
            return new ResourceResource($resource);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function show($id){
        $resource = $this->resource->findOrFail($id);
        return new ResourceResource($resource);
    }

    public function update(Request $request, $id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $resource = $this->resource->findOrFail($id);
            $fileName = ($request->has('src')) ? File::uploadFromBase64($request->src,[
                'folder1' => ($request->has('level_id')) ? $request->level_id : $resource->level_id,
                'folder2' => ($request->has('type')) ? $request->type : $resource->type
            ]) : $resource->src;
            
            if($request->has('src')){
                $resource->src = $fileName; 
            }
            if($request->has('type')){
                $resource->type = $request->type; 
            }
            if($request->has('text')){
                $resource->text = $request->text; 
            }
            if($request->has('level_id')){
                $resource->level_id = $request->level_id; 
            }
            $resource->save();
     
            return new ResourceResource($resource);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }

    public function destroy($id){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $resource = $this->resource->findOrFail($id);
            $resource->is_active = !$resource->is_active;
            $resource->save();
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
