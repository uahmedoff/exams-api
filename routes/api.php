<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1','namespace' => '\App\Http\Controllers\Api\V1'],function(){
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });
    Route::group(['middleware' => 'jwt.auth'], function ($router) {
        Route::apiResource('level','LevelController')->only('index','show');
        Route::apiResource('resource','ResourceController');
        Route::group(['prefix' => 'question'],function(){
            Route::get('numbers','QuestionDetailsController@number_of_questions');
        });
        // Route::group(['prefix' => 'question'],function(){
        //     Route::get('numbers','QuestionPlanDetailsController@number_of_question_plans');
        // });
        Route::apiResource('question','QuestionController');
        Route::apiResource('answer','AnswerController');
        Route::group(['prefix' => 'exam'],function(){
        });
        Route::group(['prefix' => 'exam'],function(){
            Route::delete('{exam_id}/results','ExamDetailsController@clear_results');
        });
        Route::apiResource('exam','ExamController');
        Route::apiResource('result','ResultController');
        Route::group(['prefix' => 'question-plan'],function(){
            Route::get('numbers','QuestionPlanDetailsController@number_of_question_plans');
        });
        Route::apiResource('question-plan','QuestionPlanController');
        Route::apiResource('resource-type','ResourceTypeController');
        Route::apiResource('question-type','QuestionTypeController');
        Route::group(['prefix' => 'student'],function(){
            Route::get('phone/{phone}','StudentController@get_student_by_phone');
            Route::post('{student_id}/exam/{exam_id}/question/{question_id}/upload','ExamDetailsController@upload_student_voice');
        });
        Route::apiResource('folder','FolderController');
    });
});
