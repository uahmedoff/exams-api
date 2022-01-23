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
use App\Models\QuestionPlan;

class ResourceController extends Controller
{
    protected $resource;

    public function __construct(Resource $resource){
        $this->resource = $resource;
        parent::__construct();
    }

    public function index(){
        $resources = $this->resource->notDeleted()->with('questions');
        $resources = $resources->filter();
        $resources = $resources->sort()->paginate($this->per_page);
        return ResourceResource::collection($resources);    
    }

    public function store(ResourceRequest $request){
        if(auth()->user()->role == User::ROLE_ADMIN){
            $fileName = ($request->src && $request->type_id) ? File::uploadFromBase64($request->src,[
                'folder1'=>$request->level_id,
                'folder2'=>$request->type_id
            ]) : null;
            $resource = $this->resource->create([
                'src' => $fileName,
                'type_id' => $request->type_id,
                'text' => $request->text,
                'level_id' => $request->level_id
            ]);
            if($request->has('qp_id')){
                QuestionPlan::find($request->qp_id)
                    ->update([
                        'resource_id' => $resource->id
                    ]);
            }
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
                'folder2' => ($request->has('type_id')) ? $request->type_id : $resource->type_id
            ]) : $resource->src;
            
            if($request->has('src')){
                $resource->src = $fileName; 
            }
            if($request->has('type_id')){
                $resource->type_id = $request->type_id; 
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
            if(!$resource->is_active)
                QuestionPlan::where('resource_id',$id)->update([
                    'resource_id' => null
                ]);
            return response()->json([],204);
        }
        return response()->json(['message'=>'You have no permission'],403);
    }
}
