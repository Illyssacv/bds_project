<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Metadata\Group;
use App\Http\Controllers\Admin\SalePostApprovalController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/app', function () {
    return view('app');
});
//login&reg
Route::controller(AuthController::class)->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });
    //

    // Protected routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
        Route::get('/user/profile', [AuthController::class, 'showProfile'])->name('user.profile');
    });
    //admin 
    Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/report', [AuthController::class, 'showReport'])->name('admin.report');
        Route::get('/posts', [AuthController::class, 'showPosts'])->name('admin.posts.index');
    });
});
//return view cho post và gọi controller
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin/posts')
    ->name('admin.posts.')
    ->group(function () {
        Route::get('approve', [SalePostApprovalController::class, 'index'])->name('approve');
        Route::get('approve/{salePost}', [SalePostApprovalController::class, 'show'])->name('approve.show');
        Route::patch('approve/{salePost}/approve', [SalePostApprovalController::class, 'approve'])->name('approve.approve');
        Route::patch('approve/{salePost}/reject', [SalePostApprovalController::class, 'reject'])->name('approve.reject');
        Route::get('create', [AuthController::class, 'showCreatePost'])->name('create');
    });
//Report review routes
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin/reports')
    ->name('admin.reports.')
    ->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('index');
        Route::patch('{id}/review-and-hide', [AuthController::class, 'reviewAndHide'])->name('review-and-hide');
        Route::patch('{id}/dismiss', [AuthController::class, 'dismiss'])->name('dismiss');
    });