<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\User;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);
        try{
            $client = new \GuzzleHttp\Client(['base_uri' => config('app.cb_url')."/api/"]);
            $res = $client->request('POST','auth/login', [
                    'headers' => [
                        'Referer' => config('app.cb_url'),
                        "Accept" => 'Application/json'
                    ],
                    'form_params' => [
                        'phone' =>  $request->phone,
                        'password' => $request->password
                    ]
                ]
            );
            $body = json_decode($res->getBody()); // 200
            if($body->user->type == 'student'){
                return response()->json(['error' => 'Unauthorized 1'], 401);
            }
        }
        catch (ClientException $e) {
            return response()->json(['error' => 'Unauthorized 2'], 401);
        }
        $b = $body;
        try{
            $client = new \GuzzleHttp\Client(['base_uri' => config('app.cb_url')."/api/"]);
            $res = $client->request('POST','auth/me', [
                'headers' => [
                    'Referer' => config('app.cb_url'),
                    "Accept" => 'Application/json',
                    "Authorization" => 'bearer '.$b->access_token,
                ],
            ]);
            $body = json_decode($res->getBody()); // 200
        }
        catch (ClientException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        foreach($body->roles as $role){
            if($role == 'Project owner' || $role == 'CEO' || $role == 'IT Manager' || $role == 'Exam Admin')
                $r = User::ROLE_ADMIN;
            elseif($role == 'Invigilator'){
                $r = User::ROLE_INVIGILATOR;
            }
            elseif($role == 'Assesser'){
                $r = User::ROLE_ASSESSER;
            }
            elseif($role == 'Assistant'){
                $r = User::ROLE_SUPERVISOR;
            }   
        }
        if(!$r)
            return response()->json(['error' => 'Unauthorized'], 401);
        $user = User::updateOrCreate(
            [
                'phone' => $b->user->phone
            ],
            [
                'name' => $b->user->staff->name,
                'crm_token' => $b->access_token,
                'role' => $r,
                'staff_id' => $b->user->staff->id
            ]
        );
        $token = auth()->login($user);
        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }

    public function me(){
        return new UserResource(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}