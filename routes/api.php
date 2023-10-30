<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TripPlanController;
use App\Http\Controllers\BadgeAwardController;
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

    Route::group(['prefix' => 'users'], function () {
        Route::post('/assign-role', [UserController::class, 'assignRole']);
        Route::post('/remove-role', [UserController::class, 'removeRole']);
        Route::post('/assign-mountain-group', [UserController::class, 'assignLeaderPermission']);
        Route::post('/revoke-mountain-group', [UserController::class, 'revokeLeaderPermission']);
        Route::get('/with-role', [UserController::class, 'getUsersWithRole']);
        Route::get('/with-mountain-groups', [UserController::class, 'getAllUsersWithMountainGroups']);
        Route::get('/with-mountain-groups/{user}', [UserController::class, 'getUserWithMountainGroups']);
    });

    // Terrain Point endpoints
    Route::group(['prefix' => 'terrain-points'], function () {
        Route::get('/', [TerrainPointController::class, 'index']);
        Route::post('/', [TerrainPointController::class, 'store']);
        Route::get('/{terrainPoint}', [TerrainPointController::class, 'show']);
        Route::put('/{terrainPoint}', [TerrainPointController::class, 'update']);
        Route::delete('/{terrainPoint}', [TerrainPointController::class, 'destroy']);
    });

    // Mountain Group endpoints
    Route::group(['prefix' => 'mountain-groups'], function () {
        Route::get('/', [MountainGroupController::class, 'index']);
        Route::post('/', [MountainGroupController::class, 'store']);
        Route::get('/with-ranges', [MountainGroupController::class, 'mountainGroupsWithMountainRanges']);
        Route::get('/{mountainGroup}', [MountainGroupController::class, 'show']);
        Route::put('/{mountainGroup}', [MountainGroupController::class, 'update']);
        Route::delete('/{mountainGroup}', [MountainGroupController::class, 'destroy']);
        Route::get('/{mountainGroup}/mountain-ranges', [MountainGroupController::class, 'mountainRanges']);
    });

    // Mountain Range endpoints
    Route::group(['prefix' => 'mountain-ranges'], function () {
        Route::get('/', [MountainRangeController::class, 'index']);
        Route::post('/', [MountainRangeController::class, 'store']);
        Route::get('/{mountainRange}', [MountainRangeController::class, 'show']);
        Route::put('/{mountainRange}', [MountainRangeController::class, 'update']);
        Route::delete('/{mountainRange}', [MountainRangeController::class, 'destroy']);
        Route::get('/{mountainRange}/sections', [MountainRangeController::class, 'sections']);
    });

    // Section endpoints
    Route::group(['prefix' => 'sections'], function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::post('/', [SectionController::class, 'store']);
        Route::get('/mountain-range/{mountainRange}/{terrainPoint?}', [SectionController::class, 'getSectionsForTripPlanning']);
        Route::get('/{section}', [SectionController::class, 'show']);
        Route::put('/{section}', [SectionController::class, 'update']);
        Route::delete('/{section}', [SectionController::class, 'destroy']);
        Route::get('/{section}/terrain-points', [SectionController::class, 'terrainPoints']);
    });

    // Trip plan endpoints
    Route::group(['prefix' => 'plans'], function () {
        Route::get('/', [TripPlanController::class, 'index']);
        Route::post('/', [TripPlanController::class, 'store']);
        Route::get('/{tripPlan}', [TripPlanController::class, 'show']);
        Route::put('/{tripPlan}', [TripPlanController::class, 'update']);
        Route::delete('/{tripPlan}', [TripPlanController::class, 'destroy']);
        Route::post('/entries', [TripPlanController::class, 'putEntry']);
        Route::delete('/entries/{tripPlanEntry}', [TripPlanController::class, 'deleteEntry']);
        Route::post('/with-entries', [TripPlanController::class, 'storeWithEntries']);
        Route::put('/with-entries/{tripPlan}', [TripPlanController::class, 'updateWithEntries']);
    });

    // Badge endpoints
    Route::group(['prefix' => 'badges'], function () {
        Route::get('/', [BadgeController::class, 'index']);
        Route::post('/', [BadgeController::class, 'store']);
        Route::get('/{badge}', [BadgeController::class, 'show']);
        Route::put('/{badge}', [BadgeController::class, 'update']);
        Route::delete('/{badge}', [BadgeController::class, 'destroy']);
    });

    //BadgeAward endpoints
    Route::group(['prefix' => 'badge-awards'], function () {
        Route::get('/', [BadgeAwardController::class, 'index']);
        Route::post('/', [BadgeAwardController::class, 'store']);
        Route::get('/{badgeAward}', [BadgeAwardController::class, 'show']);
        Route::put('/{badgeAward}', [BadgeAwardController::class, 'update']);
        Route::delete('/{badgeAward}', [BadgeAwardController::class, 'destroy']);
    });
    
    // Role Controller endpoints
    Route::post('/roles', [RoleController::class, 'createRole']);
    Route::get('/roles', [RoleController::class, 'showRoles']);
    Route::put('/roles/{role}', [RoleController::class, 'updateRole']);
    Route::delete('/roles/{role}', [RoleController::class, 'deleteRole']);
});
