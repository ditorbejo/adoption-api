<?php

use App\Http\Controllers\API\AdoptionController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\PetController;
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
Route::get('auth/role',\App\Http\Controllers\Api\Auth\RoleController::class);
Route::post('auth/register', \App\Http\Controllers\Api\Auth\RegisterController::class);
Route::post('auth/login', \App\Http\Controllers\Api\Auth\LoginController::class);
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Successfully logged out']);
});
#abilities semuanya
#ability hanya salah satu dari parameter role
Route::middleware('auth:sanctum','abilities')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('adoptions/{adoption}/adopt',[AdoptionController::class , 'adopt']);
Route::post('adoptions/adopt',[AdoptionController::class , 'markAsAdopt']);
Route::post('pets/{pet}',[PetController::class , 'update']);
Route::post('announcements/{announcement}',[AnnouncementController::class , 'update']);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('pets', PetController::class);
Route::apiResource('galleries', GalleryController::class);
Route::apiResource('adoptions', AdoptionController::class);
Route::apiResource('announcements', AnnouncementController::class);

