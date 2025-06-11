<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Security\SecurityDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

// Homepage route (accessible to guests)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form submission route
Route::post('/contact', [HomeController::class, 'contact'])->name('contact.submit');


// Breeze routes (already defined by Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Show logs (authenticated users only)

Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
Route::get('/logs/table', [LogController::class, 'table'])->name('logs.table');// AJAX route for real-time updates

Route::get('/dashboard/charts', [LogController::class, 'pieCharts']);

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// based on role
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/security/dashboard', [SecurityDashboardController::class, 'index'])->name('security.dashboard');

Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users/manage', [App\Http\Controllers\UserController::class, 'manage'])->name('admin.users.manage');
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/admin/users/export', [UserController::class, 'export'])->name('admin.users.export');
Route::get('/logs/export', [LogController::class, 'export'])->name('logs.export');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
});

Route::get('/admin/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('admin.reports.index');
Route::resource('users', \App\Http\Controllers\UserController::class);

// Add these routes to your existing routes
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/charts', [App\Http\Controllers\DashboardController::class, 'getCharts'])->name('dashboard.charts');
Route::get('/dashboard/kpis', [App\Http\Controllers\DashboardController::class, 'getKPIs'])->name('dashboard.kpis');
Route::get('/dashboard/recent-activity', [App\Http\Controllers\DashboardController::class, 'getRecentActivity'])->name('dashboard.recent-activity');
Route::get('/dashboard/trends', [App\Http\Controllers\DashboardController::class, 'getTrends'])->name('dashboard.trends');
Route::get('/dashboard/system-status', [App\Http\Controllers\DashboardController::class, 'getSystemStatus'])->name('dashboard.system-status');

require __DIR__.'/auth.php';