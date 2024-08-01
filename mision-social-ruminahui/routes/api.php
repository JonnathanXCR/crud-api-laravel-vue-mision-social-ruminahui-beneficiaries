<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\PersonController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CultivavidaGroupController;
use App\Http\Controllers\CultivavidaGroupPersonController;
 
// Rutas públicas para registro e inicio de sesión
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rutas que requieren autenticación del usuario
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'userProfile']);


    //Rutas que necesitan Auth y un Role de Usuario Especifico
    Route::apiResource('neighborhoods', NeighborhoodController::class);
    Route::apiResource('persons', PersonController::class);
    Route::apiResource('cultivavida_groups', CultivavidaGroupController::class);
    
    Route::apiResource('cultivavida_group_person', CultivavidaGroupPersonController::class);

    // Ruta adicional para obtener todas las personas registradas en un grupo específico
    Route::get('cultivavida_group_person/group/{groupId}', [CultivavidaGroupPersonController::class, 'getByGroup']);
});

