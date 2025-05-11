<?php

use Illuminate\Support\Facades\Route;
use Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sysdevproject/project/search', [ProjectController::class, 'search'])->name('projects.search');
