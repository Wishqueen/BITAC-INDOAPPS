<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

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
Route::get('/index', function () {
    return view('pages.index');
});
Route::get('/about', function () {
    return view('pages.about');
});

// Show the form to edit a course


Route::get('/instructor', function () {
    return view('pages.instructor');
});
Route::get('/detailCourse', function () {
    return view('pages.detailCourse');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth');


Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

route::resource('/course', CourseController::class);
Route::get('/tambahCourse', [CourseController::class, 'create'])->name('course.create');
Route::post('/tambahCourse', [CourseController::class, 'store'])->name('course.store');
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');