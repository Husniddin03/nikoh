<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ResultController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TestSessionController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Livewire\User\EntryForm;
use App\Livewire\User\TestWizard;
use App\Livewire\Admin\QuestionManager;
use App\Http\Controllers\ErrorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default redirect to user entry page
Route::get('/', function () {
    return redirect()->route('user.entry');
});

// User Routes (Livewire SPA)
Route::prefix('user')->name('user.')->group(function () {
    // Entry page using Livewire component
    Route::get('/entry', EntryForm::class)->name('entry');
    
    // Test wizard using Livewire component
    Route::get('/test/{session}', TestWizard::class)->name('test.show');
    
    // Results page using controller
    Route::get('/results/{session}', [ResultController::class, 'index'])->name('results');
    
    // PDF Download
    Route::get('/results/{session}/pdf', [ResultController::class, 'downloadPdf'])->name('results.pdf');
});

// Admin Auth Routes (Guest)
Route::prefix('admin')->name('admin.')->middleware('web')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['web', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [AdminController::class, 'getChartData'])->name('dashboard.chart-data');
    
    // Units CRUD
    Route::resource('units', UnitController::class);
    
    // Livewire Question Manager (must be BEFORE resource to avoid conflict)
    Route::get('/questions/manage', QuestionManager::class)->name('questions.manage');
    
    // Questions CRUD
    Route::resource('questions', QuestionController::class);
    
    // Questions Bulk Actions
    Route::post('/questions/bulk', [QuestionController::class, 'bulkAction'])->name('questions.bulk');
    
    // Questions Toggle Critical
    Route::post('/questions/{question}/toggle-critical', [QuestionController::class, 'toggleCritical'])->name('questions.toggle-critical');
    
    // Users CRUD
    Route::resource('users', UserController::class);
    
    // Test Sessions CRUD
    Route::resource('test-sessions', TestSessionController::class);
    
    // Test Session PDF Download
    Route::get('/test-sessions/{testSession}/pdf', [TestSessionController::class, 'downloadPdf'])->name('test-sessions.pdf');
    
    // Super Admin Routes (Only for super admins)
    Route::prefix('super')->name('super.')->middleware([\App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
        // Admins Management
        Route::resource('admins', SuperAdminController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Health Check Route
|--------------------------------------------------------------------------
*/
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});

/*
|--------------------------------------------------------------------------
| 404 Error Handler
|--------------------------------------------------------------------------
*/
Route::fallback([ErrorController::class, 'notFound']);
