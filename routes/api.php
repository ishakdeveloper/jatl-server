<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\TodoController;
use App\Http\Controllers\v1\CollectionController;
use App\Http\Controllers\v1\CollectionTodoController;


Route::prefix('/v1')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/user', function (Request $request) { return $request->user(); });
        Route::resource('collections', CollectionController::class);
        Route::resource('collections.todos', CollectionTodoController::class);
        Route::get('/collections/{collection}/todos/search/{search}', [CollectionTodoController::class, 'search']);
        Route::resource('todos', TodoController::class);
    });
});
