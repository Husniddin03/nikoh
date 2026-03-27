<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\AdminUserController;

Route::get('/', function () {
    return redirect()->route('survey.index');
});

// Admin Authentication Routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Add simple login route for middleware compatibility
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login');

Route::post('/login', function() {
    return redirect()->route('admin.login.post');
});

Route::prefix('survey')->name('survey.')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('index');
    Route::post('/start', [SurveyController::class, 'start'])->name('start');
    Route::get('/take/{testResult}', [SurveyController::class, 'take'])->name('take');
    Route::post('/submit/{testResult}', [SurveyController::class, 'submit'])->name('submit');
    Route::get('/reset/{testResult}', [SurveyController::class, 'resetTest'])->name('reset');
    Route::get('/result/{testResult}', [SurveyController::class, 'result'])->name('result');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/couples', [AdminController::class, 'couples'])->name('couples');
    Route::get('/couples/{couple}', [AdminController::class, 'showCouple'])->name('couples.show');
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::get('/results/{testResult}/download-pdf', [AdminController::class, 'downloadTestResultPDF'])->name('results.download.pdf');
    Route::get('/results/{testResult}/print', [AdminController::class, 'printTestResult'])->name('results.print');
    Route::delete('/results/cleanup/temp/{filename}', [AdminController::class, 'cleanupTempFile'])->name('results.cleanup.temp');
    Route::get('/chart-data', [AdminController::class, 'getChartData'])->name('chart.data');
    Route::get('/section-stats', [AdminController::class, 'getSectionStats'])->name('section.stats');
    Route::get('/compatibility-stats', [AdminController::class, 'getCompatibilityStats'])->name('compatibility.stats');
    
    // Unit routes
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');
    
    // Question routes
    Route::get('/units/{unit}/questions/create', [UnitController::class, 'createQuestion'])->name('units.questions.create');
    Route::post('/units/{unit}/questions', [UnitController::class, 'storeQuestion'])->name('units.questions.store');
    Route::get('/units/{unit}/questions/{question}/edit', [UnitController::class, 'editQuestion'])->name('units.questions.edit');
    Route::put('/units/{unit}/questions/{question}', [UnitController::class, 'updateQuestion'])->name('units.questions.update');
    Route::delete('/units/{unit}/questions/{question}', [UnitController::class, 'destroyQuestion'])->name('units.questions.destroy');
    
    // Admin user routes
    Route::get('/admins', [AdminUserController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminUserController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminUserController::class, 'store'])->name('admins.store');
    Route::get('/admins/{admin}/edit', [AdminUserController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{admin}', [AdminUserController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [AdminUserController::class, 'destroy'])->name('admins.destroy');
    Route::post('/admins/{admin}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admins.toggle');
});
