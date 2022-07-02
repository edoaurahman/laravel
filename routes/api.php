<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\RegionalController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Society Login
Route::post('/v1/auth/login' , [SocietyController::class, 'login']);
// Society Logout
Route::post('/v1/auth/logout', [SocietyController::class, 'logout']);

// Request Consultation
Route::post('/v1/consultations/{token}', [ConsultationController::class , 'reqconsul']);
// Get Consultations
Route::get('/v1/consultations/{token}' , [ConsultationController::class , 'get']);

// Get All Spots
Route::get('/v1/spots/{token}', [SpotController::class, 'spots']); 

// Get Spot by id and date
Route::get('/v1/spots/token/{token}/date/{date}/id/{id}', [SpotController::class, 'getById']);

// Register Vaccination
Route::post('/v1/vaccinations/{token}', [VaccinationController::class, 'register']);

// Get All Vaccinations
Route::get('/v1/vaccinations/{token}', [VaccinationController::class, "get"]);

Route::get('/v1/medical/{id}' , [MedicalController::class, 'show']);

// Get Region
Route::get('/v1/region/{id}' , [RegionalController::class, "show"]);