<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\LearningMaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;

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
Route::get('/detailCourse', function () {
    return view('pages.detailCourse');
});

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
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('detailCourse');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add/{courseId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{courseId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/instructor', [InstructorController::class, 'index'])->name('instructors.index');
Route::get('/instructors/create', [InstructorController::class, 'create'])->name('instructors.create');
Route::post('/instructors', [InstructorController::class, 'store'])->name('instructors.store');
Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
Route::put('/instructors/{id}', [InstructorController::class, 'update'])->name('instructors.update');
Route::delete('/instructors/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
Route::get('/instructors/{id}', [InstructorController::class, 'show'])->name('instructors.show');


Route::get('/profile', function () {
    return view('profile.index');
});
Route::get('/update', function () {
    return view('profile.update');
});
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/courses/{id}/materials', [LearningMaterialController::class, 'index'])->name('course.materials');
Route::get('/materi', function () {
    return view('learning_materials.index');
});