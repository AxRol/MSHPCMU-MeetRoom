<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route pour le tableau de bord (accessible à tous, même sans authentification)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



// Routes protégées par le middleware 'auth' et 'role:admin' (accès total)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:gestionnaire,admin,utilisateur'])->group(function () {
    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{id}/valider', [ReservationController::class, 'valider'])->name('reservations.valider');
    Route::post('/reservations/{id}/annuler', [ReservationController::class, 'annuler'])->name('reservations.annuler');

});

Route::middleware(['auth', 'role:admin,gestionnaire'])->group(function () {
    Route::resource('salles', SalleController::class);
    Route::resource('directions', DirectionController::class);
});

// Routes protégées par le middleware 'auth' (pour les utilisateurs sans rôle spécifique)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/403', function () { return view('errors.403');})->name('403');
});

// Routes d'authentification
require __DIR__.'/auth.php';
