<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'store');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::get('profile', 'profile')->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('patient', PatientController::class);
    Route::apiResource('doctor', DoctorController::class);
    Route::apiResource('appointmet', AppointmentController::class);
    Route::apiResource('medicalRecord', MedicalRecordController::class);
    Route::apiresource('user', UserController::class)->except(['store', 'show']);
});
