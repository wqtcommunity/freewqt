<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoundsController;
use App\Http\Controllers\AdminTasksController;

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

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::middleware(['throttle:auth_requests'])->post('/login', [AuthController::class, 'login_check'])->name('login.check');
// Signup
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::middleware(['throttle:auth_requests'])->post('/signup', [AuthController::class, 'signup_store'])->name('signup.store');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pages (outside dashboard)
Route::name('pages.')->group(function () {
    Route::get('/', [PagesController::class, 'index'])->name('index');
    Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
    Route::get('/winners', [PagesController::class, 'winners'])->name('winners');
    Route::get('/provably_fair', [PagesController::class, 'provably_fair'])->name('provably_fair');
});

// Dashboard
Route::name('dashboard.')->prefix('/dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/tasks', [DashboardController::class, 'tasks'])->name('tasks');
    Route::get('/current', [DashboardController::class, 'current'])->name('current');
    Route::get('/task/{task_id}/{round_id}/', [DashboardController::class, 'do_task'])->name('do_task')->where(['task_id' => '[0-9]+', 'round_id' => '[0-9]+']);
    Route::post('/task/{task_id}/{round_id}/', [DashboardController::class, 'submit_task'])->name('submit_task')->where(['task_id' => '[0-9]+', 'round_id' => '[0-9]+']);
    Route::get('/tickets', [DashboardController::class, 'tickets'])->name('tickets');
    Route::get('/results', [DashboardController::class, 'results'])->name('results');
    Route::get('/referrals', [DashboardController::class, 'referrals'])->name('referrals');
});

// Admin URLs
$admin_prefix = config('custom.admin_route_prefix', 'none');

// Admin Login
Route::get("/admin/{$admin_prefix}/login", [AdminAuthController::class, 'login'])->name('admin.login');
Route::middleware(['throttle:auth_requests'])->post("/admin/{$admin_prefix}/login", [AdminAuthController::class, 'login_check'])->name('admin.login.check');
Route::post("/admin/{$admin_prefix}/logout", [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::name('admin.dashboard.')->prefix("/admin/{$admin_prefix}/dashboard")->middleware(['auth:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    // Export Tickets
    Route::get('/export_tickets', [AdminController::class, 'export_tickets'])->name('export_tickets');
    Route::post('/export_tickets/generate', [AdminController::class, 'export_tickets_generate'])->name('export_tickets.generate');
    // Review Pending Tasks
    Route::get('/pending_tasks', [AdminController::class, 'pending_tasks'])->name('pending_tasks');
    Route::post('/pending_tasks/{user_task_id}/{action}', [AdminController::class, 'pending_tasks_action'])->name('pending_tasks.action');
    // Rounds Resource Controller
    Route::resource('rounds', AdminRoundsController::class);
    Route::patch('/rounds/activate/{round}', [AdminRoundsController::class, 'activate'])->name('rounds.activate');
    // Round Tasks Resource Controller
    Route::resource('rounds.tasks', AdminTasksController::class);
    // Submit Winners
    Route::get('/submit_winners', [AdminController::class, 'submit_winners'])->name('submit_winners');
    Route::post('/submit_winners', [AdminController::class, 'submit_winners_store'])->name('submit_winners.store');
    // Change Password
    Route::get('/change_password', [AdminController::class, 'change_password'])->name('change_password');
    Route::post('/change_password', [AdminController::class, 'change_password_store'])->name('change_password.store');
});