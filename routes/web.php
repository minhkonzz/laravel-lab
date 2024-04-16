<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PersonController;
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

Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
Route::get('/countries/{country}', [CountryController::class,'showCountry'])->name('countries.show');
Route::get('/countries/{country}/edit', [CountryController::class, 'editCountry'])->name('countries.edit');
Route::get('/create-country', [CountryController::class, 'create'])->name('countries.create');
Route::post('/countries', [CountryController::class, 'storeCountry'])->name('countries.store');
Route::put('/countries/{country}', [CountryController::class, 'updateCountry'])->name('countries.update');
Route::delete('/countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'showUser'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'editUser'])->name('users.edit');
Route::get('/create-user', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'storeUser'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'updateUser'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/persons', [PersonController::class, 'index'])->name('persons.index');
Route::get('/persons/{person}', [PersonController::class, 'showPerson'])->name('persons.show');
Route::get('/persons/{person}/edit', [PersonController::class, 'editPerson'])->name('persons.edit');
Route::get('/create-person', [PersonController::class, 'create'])->name('persons.create');
Route::post('/persons', [PersonController::class, 'storePerson'])->name('persons.store');
Route::put('/persons/{person}', [PersonController::class, 'updatePerson'])->name('persons.update');
Route::delete('/persons/{person}', [PersonController::class, 'destroy'])->name('persons.destroy');

require __DIR__.'/auth.php';
