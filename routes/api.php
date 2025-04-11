<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PersianDateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);

Route::prefix('/students')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::get('/{id}', [StudentController::class, 'show']);
    Route::get('{id}/grades', [StudentController::class, 'grades']);
    Route::get('{user}/grades/{courseTeacherId}', [StudentController::class, 'editGrade']);

})->middleware('auth:sanctum');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json($request->user());
});



Route::prefix('date')->group(function () {
    Route::get('/current', [PersianDateController::class, 'currentDate']);
    Route::get('/current-full', [PersianDateController::class, 'fullDateInfo']);
    Route::get('/convert/{date}', [PersianDateController::class, 'gregorianToJalali']);
    Route::get('/persian-date', [PersianDateController::class, 'getPersianDate']);
})->middleware('jwt.auth');



