<?php

use App\Http\Controllers\TripPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TerrainPointController;
use App\Http\Controllers\MountainGroupController;
use App\Http\Controllers\MountainRangeController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User Controller endpoints
    Route::middleware('role:admin')->post('/user/assign-role', [UserController::class, 'assignRole']);
    Route::middleware('role:admin')->post('/user/remove-role', [UserController::class, 'removeRole']);

    // Terrain Point endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/terrain-points', [TerrainPointController::class, 'index']);
        Route::get('/terrain-points/{terrainPoint}', [TerrainPointController::class, 'show']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/terrain-points', [TerrainPointController::class, 'index']);
        Route::get('/terrain-points/{terrainPoint}', [TerrainPointController::class, 'show']);
        Route::post('/terrain-points', [TerrainPointController::class, 'store']);
        Route::put('/terrain-points/{terrainPoint}', [TerrainPointController::class, 'update']);
        Route::delete('/terrain-points/{terrainPoint}', [TerrainPointController::class, 'destroy']);
    });

    // Mountain Group endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/mountain-groups', [MountainGroupController::class, 'index']);
        Route::get('/mountain-groups/with-ranges', [MountainGroupController::class, 'mountainGroupsWithMountainRanges']);
        Route::get('/mountain-groups/{mountainGroup}', [MountainGroupController::class, 'show']);
        Route::get('/mountain-groups/{mountainGroup}/mountain-ranges', [MountainGroupController::class, 'mountainRanges']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/mountain-groups', [MountainGroupController::class, 'index']);
        Route::post('/mountain-groups', [MountainGroupController::class, 'store']);
        Route::get('/mountain-groups/with-ranges', [MountainGroupController::class, 'mountainGroupsWithMountainRanges']);
        Route::get('/mountain-groups/{mountainGroup}', [MountainGroupController::class, 'show']);
        Route::put('/mountain-groups/{mountainGroup}', [MountainGroupController::class, 'update']);
        Route::delete('/mountain-groups/{mountainGroup}', [MountainGroupController::class, 'destroy']);
        Route::get('/mountain-groups/{mountainGroup}/mountain-ranges', [MountainGroupController::class, 'mountainRanges']);
    });

    // Mountain Range endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/mountain-ranges', [MountainRangeController::class, 'index']);
        Route::get('/mountain-ranges/{mountainRange}', [MountainRangeController::class, 'show']);
        Route::get('/mountain-ranges/{mountainRange}/sections', [MountainRangeController::class, 'sections']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/mountain-ranges', [MountainRangeController::class, 'index']);
        Route::post('/mountain-ranges', [MountainRangeController::class, 'store']);
        Route::get('/mountain-ranges/{mountainRange}', [MountainRangeController::class, 'show']);
        Route::put('/mountain-ranges/{mountainRange}', [MountainRangeController::class, 'update']);
        Route::delete('/mountain-ranges/{mountainRange}', [MountainRangeController::class, 'destroy']);
        Route::get('/mountain-ranges/{mountainRange}/sections', [MountainRangeController::class, 'sections']);
    });

    // Section endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/sections', [SectionController::class, 'index']);
        Route::get('/sections/mountain-range/{mountainRange}/{terrainPoint?}', [SectionController::class, 'getSectionsForTripPlanning']);
        Route::get('/sections/{section}', [SectionController::class, 'show']);
        Route::get('/sections/{section}/terrain-points', [SectionController::class, 'terrainPoints']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/sections', [SectionController::class, 'index']);
        Route::post('/sections', [SectionController::class, 'store']);
        Route::get('/sections/mountain-range/{mountainRange}/{terrainPoint?}', [SectionController::class, 'getSectionsForTripPlanning']);
        Route::get('/sections/{section}', [SectionController::class, 'show']);
        Route::put('/sections/{section}', [SectionController::class, 'update']);
        Route::delete('/sections/{section}', [SectionController::class, 'destroy']);
        Route::get('/sections/{section}/terrain-points', [SectionController::class, 'terrainPoints']);
    });

    // Trip plan endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/plans', [TripPlanController::class, 'index']);
        Route::get('/plans/{tripPlan}', [TripPlanController::class, 'show']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/plans', [TripPlanController::class, 'index']);
        Route::post('/plans', [TripPlanController::class, 'store']);
        Route::get('/plans/{tripPlan}', [TripPlanController::class, 'show']);
        Route::put('/plans/{tripPlan}', [TripPlanController::class, 'update']);
        Route::delete('/plans/{tripPlan}', [TripPlanController::class, 'destroy']);
        Route::post('/plans/entries', [TripPlanController::class, 'putEntry']);
        Route::delete('/plans/entries/{tripPlanEntry}', [TripPlanController::class, 'deleteEntry']);
        Route::post('/with-entries', [TripPlanController::class, 'storeWithEntries']);
        Route::put('/with-entries/{tripPlan}', [TripPlanController::class, 'updateWithEntries']);
    });

    // Role Controller endpoints
    Route::middleware('role:user')->group(function () {
        Route::get('/roles', [RoleController::class, 'showRoles']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::post('/roles', [RoleController::class, 'createRole']);
        Route::get('/roles', [RoleController::class, 'showRoles']);
        Route::put('/roles/{role}', [RoleController::class, 'updateRole']);
        Route::delete('/roles/{role}', [RoleController::class, 'deleteRole']);
    });
});
