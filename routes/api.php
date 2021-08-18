<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\VoteController;
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

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

/**
 * Threads
 */
Route::apiResource('threads', ThreadController::class);

/**
 * Voting
 */
Route::post('votes/up', [VoteController::class, 'upVote']);
Route::post('votes/down', [VoteController::class, 'downVote']);

/**
 * Comment
 */
Route::get('comments/{thread:id}', [\App\Http\Controllers\CommentController::class, 'index']);
Route::post('comments/{thread:id}', [\App\Http\Controllers\CommentController::class, 'store']);
Route::post('reply/{comment:id}', [\App\Http\Controllers\CommentController::class, 'store']);
Route::put('comments/{comment:id}', [\App\Http\Controllers\CommentController::class, 'update']);
Route::delete('comments/{comment:id}', [\App\Http\Controllers\CommentController::class, 'destroy']);


/**
 * Authentication
 */
Route::group(['prefix' => 'auth'], function () {
    Route::delete('/destroy', [AuthController::class, 'destroyAccount'])
        ->middleware(['auth:sanctum', 'password.confirm']);
});
