<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('x', function () {
        return response()->json(['message' => 'Hello World']);
    });
    // Plant
    Route::get('plants', [App\Http\Controllers\PlantsController::class, 'index']);
    Route::post('plants', [App\Http\Controllers\PlantsController::class, 'store']);
    Route::get('plants/{plant}', [App\Http\Controllers\PlantsController::class, 'show']);
    Route::put('plants/{plant}', [App\Http\Controllers\PlantsController::class, 'update']);
    Route::delete('plants/{plant}', [App\Http\Controllers\PlantsController::class, 'destroy']);
    // UserPlant
    Route::get('user-plants', [App\Http\Controllers\UserPlantsController::class, 'index']);
    Route::post('user-plants', [App\Http\Controllers\UserPlantsController::class, 'store']);
    Route::get('user-plants/{userPlant}', [App\Http\Controllers\UserPlantsController::class, 'show']);
    Route::put('user-plants/{userPlant}', [App\Http\Controllers\UserPlantsController::class, 'update']);
    Route::delete('user-plants/{userPlant}', [App\Http\Controllers\UserPlantsController::class, 'destroy']);

    //WategingLog
    Route::get('watering-logs', [App\Http\Controllers\WateringLogsController::class, 'index']);
    Route::post('watering-logs', [App\Http\Controllers\WateringLogsController::class, 'store']);
    Route::get('watering-logs/{wateringLog}', [App\Http\Controllers\WateringLogsController::class, 'show']);
    Route::put('watering-logs/{wateringLog}', [App\Http\Controllers\WateringLogsController::class, 'update']);
    Route::delete('watering-logs/{wateringLog}', [App\Http\Controllers\WateringLogsController::class, 'destroy']);

    // TaxonomicClassification
    Route::get('taxonomic-classifications', [App\Http\Controllers\TaxonomicClassificationController::class, 'index']);
    Route::post('taxonomic-classifications', [App\Http\Controllers\TaxonomicClassificationController::class, 'store']);
    Route::get('taxonomic-classifications/{taxonomicClassification}', [App\Http\Controllers\TaxonomicClassificationController::class, 'show']);
    Route::put('taxonomic-classifications/{taxonomicClassification}', [App\Http\Controllers\TaxonomicClassificationController::class, 'update']);
    Route::delete('taxonomic-classifications/{taxonomicClassification}', [App\Http\Controllers\TaxonomicClassificationController::class, 'destroy']);
});
