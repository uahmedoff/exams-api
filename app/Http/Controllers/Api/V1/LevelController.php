<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Resources\LevelIndexResource;

class LevelController extends Controller
{
    protected $level;
    
    public function __construct(Level $level){
        $this->level = $level;
        parent::__construct();
    }

    public function index(Request $request){
        $levels = $this->level;        
        if ($str = $request->search){
            $levels = $levels->search($str);
        }
        $levels = $levels->with('questions')->sort()->paginate($this->per_page);
        return LevelIndexResource::collection($levels);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id){
        $level = $this->level->find($id);
        return new LevelResource($level);
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
