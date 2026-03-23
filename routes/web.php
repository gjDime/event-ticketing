<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AdminDashboard;
use App\Livewire\CheckIn;
use App\Livewire\VisitorManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/tickets/{ticket}/success', [EventController::class, 'ticketSuccess'])->name('tickets.success');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/events/{event}/visitors', VisitorManagement::class)->name('admin.visitors');
    Route::get('/check-in', CheckIn::class)->name('admin.check-in');
});

require __DIR__.'/auth.php';
