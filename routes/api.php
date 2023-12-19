<?php

use App\Events\ChatCattery;
use App\Http\Controllers\API\AdoptionController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\ChatsController;
use App\Http\Controllers\API\Auth\RoleController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
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
Route::get('/getAllColor',[PetController::class , 'getAllColor']);
Route::get('/chat', [ChatsController::class, 'index']);
Route::get('/getAllUser', [ChatsController::class, 'getAllUser']);
Route::post('/messages', [ChatsController::class, 'sendMessageUser']);
Route::post('/messages/{userId}', [ChatsController::class, 'sendMessageAdmin']);
Route::get('/messages', [ChatsController::class, 'fetchMessages']);
Route::get('/messages/{userId}', [ChatsController::class, 'fetchMessagesAdmin']);

Route::get('/test-broadcast-event', function () {
    ChatCattery::dispatch('ini adalah parameter message chat cattery');
    
    echo 'test broadcast event chat cattery';
});

Route::get('auth/role',RoleController::class);
Route::post('auth/register',RegisterController::class);
Route::post('auth/login', LoginController::class);
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Successfully logged out']);
});

Route::middleware('auth:sanctum','abilities')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('adoptions/checkHistoryUserAdopt',[AdoptionController::class , 'checkHistoryUserAdopt']);
Route::post('adoptions/{adoption}/reject',[AdoptionController::class , 'reject']);
Route::post('adoptions/{adoption}/adopt',[AdoptionController::class , 'adopt']);
Route::post('adoptions/adopt',[AdoptionController::class , 'markAsAdopt']);
Route::post('pets/{pet}',[PetController::class , 'update']);
Route::get('pets/{petId}/adoptions',[PetController::class , 'formAdoptionsPet']);
Route::get('pets/home',[PetController::class , 'getPetForHalamanHome']);
Route::post('announcements/{announcement}',[AnnouncementController::class , 'update']);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('pets', PetController::class);
Route::apiResource('galleries', GalleryController::class);
Route::apiResource('adoptions', AdoptionController::class);
Route::apiResource('announcements', AnnouncementController::class);

