<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\GradeController;
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/filter', [StudentController::class, 'filter'])->name('students.filter');
Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
Route::post('/grades/search', [GradeController::class, 'search'])->name('grades.search');
Route::post('/grades/update/{id}', [GradeController::class, 'update'])->name('grades.update');
Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('/grades/store', [GradeController::class, 'store'])->name('grades.store');
Route::delete('/grades/{id}', [GradeController::class, 'destroy'])->name('grades.destroy');
Route::get('/results', [ResultController::class, 'index'])->name('results.index');
Route::get('/results/data', [ResultController::class, 'data'])->name('results.data');
Route::post('/results/reset-data', [ResultController::class, 'resetData'])->name('results.reset.data');
Route::get('/results/check-master-data', [ResultController::class, 'checkMasterData'])->name('results.check.master.data');
Route::post('/results/{id}', [ResultController::class, 'update'])->name('results.update');
Route::post('/generate-dummy-data', [ResultController::class, 'generateDummyData'])->name('generate.dummy.data');