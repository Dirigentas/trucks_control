<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckSubunitController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('trucks', TruckController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

Route::get('/subunits/create{truck}', [TruckSubunitController::class, 'create'])->name('subunits.create');
Route::post('/subunits/store{truck}', [TruckSubunitController::class, 'store'])->name('subunits.store');

// Route::resource('subunits', TruckSubunitController::class);

require __DIR__.'/auth.php';
