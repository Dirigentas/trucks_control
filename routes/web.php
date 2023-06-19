<?php

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

Route::resource('trucks', TruckController::class);

Route::get('/subunits/create{truck}', [TruckSubunitController::class, 'create'])->name('subunits.create');
Route::post('/subunits/store{truck}', [TruckSubunitController::class, 'store'])->name('subunits.store');


require __DIR__.'/auth.php';
