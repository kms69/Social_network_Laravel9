<?php

use App\Http\Controllers\API\v1\UserController;


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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::middleware(['auth:api'])->group(function () {
    Route::post('/unfollow/', [UserController::class, 'unfollowUser']);
    Route::post('/follow/', [UserController::class, 'followUser']);
    Route::get('/get_following/{get_following}', [UserController::class, 'getfollowing']);
    Route::get('/get_followers/{get_followers}', [UserController::class, 'getfollower']);

});
