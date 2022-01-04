<?php

use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TopicController;
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


Route::prefix('/v1')->group(function () {

    Route::prefix('/tags')->group(function () {
        Route::get('/populate', [TagController::class, 'getAllTags']);
        Route::post('/create', [TagController::class, 'createTag']);
        Route::post('/update/{uuidTag}', [TagController::class, 'updateTagByUuid']);
        Route::delete('/delete/{uuidTag}', [TagController::class, 'deleteTagByUuid']);
    });

    Route::prefix('/topic')->group(function () {
        Route::get('/populate', [TopicController::class, 'getAllTopics']);
        Route::post('/create', [TopicController::class, 'createTopic']);
        Route::post('/update/{uuidTag}', [TopicController::class, 'updateTopicByUuid']);
        Route::delete('/delete/{uuidTag}', [TopicController::class, 'deleteTopicByUuid']);
    });
});
