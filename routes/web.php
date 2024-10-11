<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    /* ---------Permission Route---------- */
    Route::get('/permission',[PermissionController::class,'index'])->name('permission.index');
    Route::get('/permission/create',[PermissionController::class,'create'])->name('permission.create');
    Route::post('/permission',[PermissionController::class,'store'])->name('permission.store');
    Route::get('/permission/edit/{id}',[PermissionController::class,'edit'])->name('permission.edit');
    Route::put('/permission/update/{id}',[PermissionController::class,'update'])->name('permission.update');
    Route::delete('/permission',[PermissionController::class,'destroy'])->name('permission.destroy');

    /* ---------Roles Route---------- */
    Route::get('/role',[RoleController::class,'index'])->name('role.index');
    Route::get('/role/create',[RoleController::class,'create'])->name('role.create');
    Route::post('/role',[RoleController::class,'store'])->name('role.store');
    Route::get('/role/{id}/edit/',[RoleController::class,'edit'])->name('role.edit');
    Route::put('/role/{id}/update/',[RoleController::class,'update'])->name('role.update');
    Route::delete('/role',[RoleController::class,'destroy'])->name('role.destroy');

    /* ---------Articles Route---------- */
    Route::get('/article',[ArticleController::class,'index'])->name('article.index');
    Route::get('/article/create',[ArticleController::class,'create'])->name('article.create');
    Route::post('/article',[ArticleController::class,'store'])->name('article.store');
    Route::get('/article/{id}/edit',[ArticleController::class,'edit'])->name('article.edit');
    Route::put('/article/{id}/update',[ArticleController::class,'update'])->name('article.update');
    Route::delete('/article',[ArticleController::class,'destroy'])->name('article.destroy');

    /* ---------Users Route---------- */
    Route::get('/user',[UserController::class,'index'])->name('user.index');
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user',[UserController::class,'store'])->name('user.store');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{id}/update',[UserController::class,'update'])->name('user.update');
    Route::delete('/user',[UserController::class,'destroy'])->name('user.destroy');



});

require __DIR__.'/auth.php';


