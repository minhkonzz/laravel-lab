<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

use App\Models\Company;

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

Route::middleware(['web', 'auth'])->group(function () {

    Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::get('/{country}', [CountryController::class, 'show'])->name('show');
        Route::get('/{country}/edit', [CountryController::class, 'edit'])->name('edit');
        Route::post('/countries', [CountryController::class, 'store'])->name('store');
        Route::put('/{country}', [CountryController::class, 'update'])->name('update');
        Route::delete('/{country}', [CountryController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-country', [CountryController::class, 'create'])->name('countries.create');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-user', [UserController::class, 'create'])->name('users.create');

    Route::group(['prefix' => 'persons', 'as' => 'persons.'], function () {
        Route::get('/', [PersonController::class, 'index'])->name('index');
        Route::get('/{person}', [PersonController::class, 'show'])->name('show');
        Route::get('/{person}/edit', [PersonController::class, 'edit'])->name('edit');
        Route::post('/', [PersonController::class, 'store'])->name('store');
        Route::put('/{person}', [PersonController::class, 'update'])->name('update');
        Route::delete('/{person}', [PersonController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-person', [PersonController::class, 'create'])->name('persons.create');

    Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/{company}', [CompanyController::class, 'show'])->name('show');
        Route::get('/{company}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::get('/{company}/persons', [CompanyController::class, 'getPersons']);
        Route::post('/', [CompanyController::class, 'store'])->name('store')->can('create', Company::class);
        Route::put('/{company}', [CompanyController::class, 'update'])->name('update');
        Route::delete('/{company}', [CompanyController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-company', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies/{company}/departments', [CompanyController::class, 'storeDepartment'])->name('departments.store');
    Route::get('/companies/{company}/create-department', [CompanyController::class, 'createDepartment'])->name('departments.create');

    Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
        Route::get('/{department}/edit', [CompanyController::class, 'editDepartment'])->name('edit');
        Route::put('/{department}', [CompanyController::class, 'updateDepartment'])->name('update');
        Route::delete('/{department}', [CompanyController::class, 'destroyDepartment'])->name('destroy');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-role', [RoleController::class, 'create'])->name('roles.create');

    Route::group(['prefix' => 'projects', 'as' => 'projects.'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::get('/{project}/persons', [ProjectController::class, 'getPersons']);
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-project', [ProjectController::class, 'create'])->name('projects.create');

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    });

    Route::get('/create-task', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks-export', [TaskController::class, 'export'])->name('tasks.export');
    Route::get('/tasks-filter', [TaskController::class, 'filter'])->name('tasks.filter');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
