<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamController;


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/',          [HomeController::class, 'index']);
Route::get('/about',     [HomeController::class, 'about']);
Route::get('/services',  [HomeController::class, 'services']);
Route::get('/portfolio', [HomeController::class, 'portfolio']);
Route::get('/reviews',   [HomeController::class, 'reviews']);
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// FIX: Give the GET contact route a name so redirect()->route('contact') works
Route::get('/contact',   [HomeController::class, 'contact'])->name('contact');
Route::post('/contact',  [HomeController::class, 'submitContact'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/register',  [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login',     [AuthController::class, 'showLogin']);
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/logout',    [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/dashboard',         [DashboardController::class, 'index']);

    // Bookings
    Route::get('/bookings',          [BookingController::class, 'index']);
    Route::post('/bookings',         [BookingController::class, 'store']);
    Route::put('/bookings/{booking}', [BookingController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);

    // Clients
    Route::get('/clients',           [ClientController::class, 'index']);

    // Portfolio
    Route::get('/portfolio-manage',  [PortfolioController::class, 'index']);
    Route::post('/portfolio-manage', [PortfolioController::class, 'store']);
    Route::put('/portfolio-manage/{portfolioItem}',    [PortfolioController::class, 'update']);
    Route::delete('/portfolio-manage/{portfolioItem}', [PortfolioController::class, 'destroy']);

    // Services
    Route::get('/services-manage',   [ServiceController::class, 'index']);
    Route::post('/services-manage',  [ServiceController::class, 'store']);
    Route::put('/services-manage/{service}',    [ServiceController::class, 'update']);
    Route::delete('/services-manage/{service}', [ServiceController::class, 'destroy']);

    // Reviews
    Route::get('/reviews-manage',    [ReviewController::class, 'index']);
    Route::post('/reviews-manage/{review}/approve', [ReviewController::class, 'approve']);
    Route::post('/reviews-manage/{review}/reject',  [ReviewController::class, 'reject']);
    Route::delete('/reviews-manage/{review}',       [ReviewController::class, 'destroy']);

    // Messages
    Route::get('/messages',          [MessageController::class, 'index']);
    Route::post('/messages/mark-all-read', [MessageController::class, 'markAllRead']);
    Route::post('/messages/{message}/read', [MessageController::class, 'markRead']);
    Route::delete('/messages/{message}',   [MessageController::class, 'destroy']);

    // Reports
    Route::get('/reports',           [ReportController::class, 'index']);

    // Settings
    Route::get('/settings',          [SettingController::class, 'index']);
    Route::post('/settings',         [SettingController::class, 'update']);

    Route::get('/team',               [TeamController::class, 'index'])->name('admin.team');
    Route::post('/team/store',        [TeamController::class, 'store'])->name('admin.team.store');
    Route::delete('/team/delete/{id}',[TeamController::class, 'delete'])->name('admin.team.delete');
});


