<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ResourceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceTypeRequest;
use App\Http\Resources\ResourceTypeResource;

class ResourceTypeController extends Controller
{
    protected $resource_type;

    public function __construct(ResourceType $resource_type){
        $this->resource_type = $resource_type;
        parent::__construct();
    }

    public function index(){
        $resource_types = $this->resource_type->all();
        return ResourceTypeResource::collection($resource_types);
    }

    public function store(ResourceTypeRequest $request){
        // $resource_type = $this->resource_type->create([
        //     'name' => $request->name
        // ]);
        // return new ResourceType($resource_type);
    }

    public function show($id){
        $resource_type = $this->resource_type->find($id);
        return new ResourceTypeResource($resource_type);
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
