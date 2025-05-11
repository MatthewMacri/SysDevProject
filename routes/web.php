<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\entitiesControllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/project/search', [ProjectController::class, 'search'])->name('projects.search');
