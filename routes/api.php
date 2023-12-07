<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Admin;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {
    return $request->user();
});


Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

Route::post('admin/login',[AdminController::class,'login']);
Route::post('admin/register',[AdminController::class,'register']);


Route::middleware(['auth:sanctum', 'type.user'])->group(function () {
    Route::get('/users/orders', function(Request $request){
        
        return 'logout';
    });
});
// Only for admins
Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {
    Route::get('/admins', function(Request $request){
        return "";
        // return $request->user();
    });
    Route::get('/admins/logout', function(Request $request){
        return $request->user()->currentAccessToken()->delete();
    });
      
      
});


