<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\LearningMaterialController;
use App\Http\Controllers\LearningScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudentController;

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

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
});
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('password/reset/{token}', function ($token) {
    return view('auth.reset_password', ['token' => $token]); // Ganti dengan view Anda
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


route::resource('/course', CourseController::class);
Route::get('/tambahCourse', [CourseController::class, 'create'])->name('course.create');
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('detailCourse');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/detailCourse', function () {
    return view('pages.detailCourse');
});
Route::get('/student', [StudentController::class, 'index2'])->name('students.index2');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');


// Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
// Route::post('/cart/add/{courseId}', [CartController::class, 'addToCart'])->name('cart.add');
// Route::post('/cart/remove/{courseId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/instructor', [InstructorController::class, 'index'])->name('instructors.index');
Route::get('/instructors/create', [InstructorController::class, 'create'])->name('instructors.create');
Route::post('/instructors', [InstructorController::class, 'store'])->name('instructors.store');
Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
Route::put('/instructors/{id}', [InstructorController::class, 'update'])->name('instructors.update');
Route::delete('/instructors/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
Route::get('/instructors/{id}', [InstructorController::class, 'show'])->name('instructors.show');



// Route::get('/courses/{id}/materials', [LearningMaterialController::class, 'index'])->name('course.materials');
// Route::get('/materi', function () {
//     return view('learning_materials.index');
// });

Route::middleware('auth')->group(function() {
    Route::get('/profile', function () {
        return view('profile.index');
    });
    Route::get('/update', function () {
        return view('profile.update');
    });
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/download', [AttendanceController::class, 'downloadReport'])->name('attendance.download');
    
    Route::get('/learning-schedule/events', [LearningScheduleController::class, 'getEvents'])->name('learning-schedule.events');
    Route::resource('learning-schedule', LearningScheduleController::class);
    Route::post('/learning-schedule/update/{id}', [LearningScheduleController::class, 'update'])->name('learning-schedule.update');
    
    Route::resource('certifications', CertificationController::class);
    Route::post('/certifications', [CertificationController::class, 'store'])->name('certifications.store');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

});


Route::middleware(['role:admin'])->group(function () {
   
});

Route::middleware(['role:instructor'])->group(function () {
    
});


