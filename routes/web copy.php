<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route pour le tableau de bord (accessible à tous, même sans authentification)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


/* Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('salles', SalleController::class);
    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::resource('directions', DirectionController::class);
    Route::resource('users', UserController::class);
    Route::get('/403', function () {return view('403');})->name('403');
}); */

 // Routes protégées par le middleware 'auth' et 'role:admin' (accès total)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('profile', ProfileController::class)->only(['edit', 'update', 'destroy']);
    Route::resource('salles', SalleController::class);
    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::resource('directions', DirectionController::class);
    Route::resource('users', UserController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Routes protégées par le middleware 'auth' et 'role:gestionnaire'
Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('salles', SalleController::class);
    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::resource('directions', DirectionController::class);
});

// Routes protégées par le middleware 'auth' et 'role:utilisateur'
Route::middleware(['auth', 'role:utilisateur'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reservations', ReservationController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*// Routes protégées par le middleware 'auth' (pour les utilisateurs sans rôle spécifique)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
}); */

// Routes d'authentification
require __DIR__.'/auth.php';
