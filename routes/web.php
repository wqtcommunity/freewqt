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
    Route::get('/fair_draw', [PagesController::class, 'fair_draw'])->name('fair_draw');
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
    Route::get('/users/login_as/{user_id}', [AdminController::class, 'login_as_user'])->name('login_as_user')->where(['user_id' => '[0-9]+']);
    Route::get('/users/change_password/{user_id}', [AdminController::class, 'change_user_password'])->name('change_user_password')->where(['user_id' => '[0-9]+']);
    Route::patch('/users/change_password/{user_id}', [AdminController::class, 'change_user_password_store'])->name('change_user_password_store')->where(['user_id' => '[0-9]+']);
    // Top Referrers
    Route::get('/top_referrers', [AdminController::class, 'top_referrers'])->name('top_referrers');
    // Export Tickets
    Route::get('/export_tickets', [AdminController::class, 'export_tickets'])->name('export_tickets');
    Route::post('/export_tickets/generate', [AdminController::class, 'export_tickets_generate'])->name('export_tickets.generate');
    // Review Pending Tasks
    Route::get('/pending_tasks', [AdminController::class, 'pending_tasks'])->name('pending_tasks');
    Route::post('/pending_tasks/{user_task_id}/{action}', [AdminController::class, 'pending_tasks_action'])->name('pending_tasks.action');
    // Batch Approval
    Route::get('/batch_approval', [AdminController::class, 'batch_approval'])->name('batch_approval');
    Route::post('/batch_approval', [AdminController::class, 'batch_approval_action'])->name('batch_approval.action');
    // Tickets
    Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
    Route::post('/tickets/action', [AdminController::class, 'tickets_action'])->name('tickets.action');
    // Rounds Resource Controller
    Route::resource('rounds', AdminRoundsController::class);
    Route::patch('/rounds/activate/{round}', [AdminRoundsController::class, 'activate'])->name('rounds.activate');
    // Round Tasks Resource Controller
    Route::resource('rounds.tasks', AdminTasksController::class);
    // Find Winning Tickets
    Route::get('/find_winners', [AdminController::class, 'find_winners'])->name('find_winners');
    Route::post('/find_winners', [AdminController::class, 'find_winners_action'])->name('find_winners.action');
    // Find Lottery Winners
    Route::get('/find_lottery_winners', [AdminController::class, 'find_lottery_winners'])->name('find_lottery_winners');
    Route::post('/find_lottery_winners', [AdminController::class, 'find_lottery_winners_action'])->name('find_lottery_winners.action');
    // Test Winning Tickets
    Route::get('/test_winning_tickets', [AdminController::class, 'test_winning_tickets'])->name('test_winning_tickets');
    Route::post('/test_winning_tickets', [AdminController::class, 'test_winning_tickets_action'])->name('test_winning_tickets.action');
    // Winners
    Route::get('/list_winners', [AdminController::class, 'list_winners'])->name('list_winners');
    Route::post('/roll_back_a_winner', [AdminController::class, 'roll_back_a_winner'])->name('roll_back_a_winner');
    // Submit Winners
    Route::get('/submit_winners', [AdminController::class, 'submit_winners'])->name('submit_winners');
    Route::post('/submit_winners', [AdminController::class, 'submit_winners_store'])->name('submit_winners.store');
    // Change Password
    Route::get('/change_password', [AdminController::class, 'change_password'])->name('change_password');
    Route::post('/change_password', [AdminController::class, 'change_password_store'])->name('change_password.store');
});


// Cron Jobs
Route::get("/cron/{$admin_prefix}/batch/approve/miShDJzI", [AdminTasksController::class, 'cron_approve'])->name('cron.approve');
