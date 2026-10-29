<?php

use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::resource('skills', SkillController::class)->except(['show', 'create', 'edit']);
    Route::resource('projects', ProjectController::class)->except(['show', 'create', 'edit']);
    Route::resource('experiences', ExperienceController::class)->except(['show', 'create', 'edit']);
});
