<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\SectionController;
use App\Http\Controllers\TerrainPointController;
use App\Http\Controllers\MountainGroupController;
use App\Http\Controllers\MountainRangeController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'terrain-points'], function () {
        Route::get('/', [TerrainPointController::class, 'index']);
        Route::post('/', [TerrainPointController::class, 'store']);
        Route::get('/{terrainPoint}', [TerrainPointController::class, 'show']);
        Route::put('/{terrainPoint}', [TerrainPointController::class, 'update']);
        Route::delete('/{terrainPoint}', [TerrainPointController::class, 'destroy']);
    });

    Route::group(['prefix' => 'mountain-groups'], function () {
        Route::get('/', [MountainGroupController::class, 'index']);
        Route::post('/', [MountainGroupController::class, 'store']);
        Route::get('/{mountainGroup}', [MountainGroupController::class, 'show']);
        Route::put('/{mountainGroup}', [MountainGroupController::class, 'update']);
        Route::delete('/{mountainGroup}', [MountainGroupController::class, 'destroy']);
        Route::get('/{mountainGroup}/mountain-ranges', [MountainGroupController::class, 'mountainRanges']);
    });

    Route::group(['prefix' => 'mountain-ranges'], function () {
        Route::get('/', [MountainRangeController::class, 'index']);
        Route::post('/', [MountainRangeController::class, 'store']);
        Route::get('/{mountainRange}', [MountainRangeController::class, 'show']);
        Route::put('/{mountainRange}', [MountainRangeController::class, 'update']);
        Route::delete('/{mountainRange}', [MountainRangeController::class, 'destroy']);
        Route::get('/{mountainRange}/sections', [MountainRangeController::class, 'sections']);
    });

    Route::group(['prefix' => 'sections'], function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::post('/', [SectionController::class, 'store']);
        Route::get('/{section}', [SectionController::class, 'show']);
        Route::put('/{section}', [SectionController::class, 'update']);
        Route::delete('/{section}', [SectionController::class, 'destroy']);
        Route::get('/{section}/terrain-points', [SectionController::class, 'terrainPoints']);
    });
});
