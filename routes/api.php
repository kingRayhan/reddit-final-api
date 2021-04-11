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
Route::apiResource('threads', ThreadController::class);
Route::post('votes/up', [VoteController::class, 'upVote']);
Route::post('votes/down', [VoteController::class, 'downVote']);

Route::group(['prefix' => 'auth'], function () {
    Route::delete('/destroy', [AuthController::class, 'destroyAccount'])
        ->middleware(['auth:sanctum', 'password.confirm']);
});
