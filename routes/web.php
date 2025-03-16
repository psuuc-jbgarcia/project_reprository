<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crud;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('webpage.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/add',[Crud::class,'add'])->name('add');
Route::get('/dashboard',[Crud::class,'display'])->name('dashboard');
Route::get('/delete/{id}',[Crud::class, 'delete'])->name('delete');
Route::get('/project/edit/{id}', [Crud::class, 'edit'])->name('edit_project');
Route::post('/project/save', [Crud::class, 'save'])->name('save_project');
Route::get('/guest',[Crud::class, 'guest'])->name('guest');

require __DIR__.'/auth.php';
