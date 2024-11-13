<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\LearningMaterialController;
use App\Http\Controllers\LearningScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;

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
    return view('pages.index');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/register2', function () {
    return view('auth.instructor_register');
})->name('register2');
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
Route::get('/mycourses', [CourseController::class, 'myCourses'])->name('course.myCourses');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('detailCourse');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/detailCourse', function () {
    return view('pages.detailCourse');
});
// Route to set currency

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

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    
    
});

Route::post('/instructor/pending', [InstructorController::class, 'storePending'])->name('instructor.pending');
Route::get('/instructor/pending', [InstructorController::class, 'create'])->name('instructor.create');

// Admin routes to approve/reject instructors
Route::get('/admin/instructors/pending', [AdminController::class, 'pendingInstructors'])->name('admin.instructors.pending');
Route::post('/admin/instructor/{id}/approve', [AdminController::class, 'approveInstructor'])->name('admin.instructor.approve');
Route::post('/admin/instructor/{id}/reject', [AdminController::class, 'rejectInstructor'])->name('admin.instructor.reject');


// Route::get('/courses/{id}/materials', [LearningMaterialController::class, 'index'])->name('course.materials');
// Route::get('/materi', function () {
//     return view('learning_materials.index');
// });

Route::middleware('auth')->group(function() {
    // Route::get('/profile', function () {
    //     return view('profile.index');
    // });
    Route::get('/update', function () {
        return view('profile.update');
    });
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.edit');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/download', [AttendanceController::class, 'downloadReport'])->name('attendance.download');
    
    Route::get('/learning-schedule', [LearningScheduleController::class, 'index'])->name('learning-schedule.index');
    Route::resource('learning-schedule', LearningScheduleController::class);
    Route::post('/learning-schedule/store', [LearningScheduleController::class, 'store'])->name('learning-schedule.store');
    Route::post('/learning-schedule/update/{id}', [LearningScheduleController::class, 'update'])->name('learning-schedule.update');
    Route::delete('/learning-schedule/{id}', [LearningScheduleController::class, 'destroy'])->name('learning-schedule.destroy');
    
    
    Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');
    Route::get('/certifications/{id}', [CertificationController::class, 'show'])->name('certifications.show');
    Route::resource('certifications', CertificationController::class);
    Route::get('/certificate/download/{id}', [CertificationController::class, 'download'])->name('certificate.download');
    Route::get('/get-users-by-course', [CertificationController::class, 'getUsersByCourse'])->name('get.users.by.course');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

});


Route::get('/learning-materials/create', [LearningMaterialController::class, 'create'])->name('learning-materials.create');
Route::post('/learning-materials', [LearningMaterialController::class, 'store'])->name('learning-materials.store');
Route::get('/learning-materials', [LearningMaterialController::class, 'index'])->name('learning-materials.index');

Route::get('/learning-materials/{id}/edit', [LearningMaterialController::class, 'edit'])->name('learning-materials.edit');
Route::put('/learning-materials/{id}', [LearningMaterialController::class, 'update'])->name('learning-materials.update');

Route::delete('/learning-materials/{id}', [LearningMaterialController::class, 'destroy'])->name('learning-materials.destroy');




// routes/web.php
// Route::get('/checkout/{course}', [CheckoutController::class, 'checkoutForm'])->name('checkout.form')->middleware('auth');
// Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process')->middleware('auth');
// Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success')->middleware('auth');




// Route untuk menampilkan keranjang
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

// Route untuk menambahkan course ke keranjang
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');


// Route untuk menampilkan form checkout (mengirim course ID)
Route::get('/checkout/form/{id}', [CartController::class, 'checkoutForm'])->name('checkout.form');

// Route untuk menampilkan halaman checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');



// Route untuk menangani proses pembayaran dari Midtrans
Route::post('/payment/handle', [CartController::class, 'handlePayment'])->name('payment.handle');
Route::post('/payment/callback', [CartController::class, 'handlePaymentCallback']);



// routes/web.php
Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
Route::post('/admin/transactions/{id}/confirm', [AdminController::class, 'confirmTransaction'])->name('admin.transactions.confirm');
Route::post('/admin/transactions/{id}/reject', [AdminController::class, 'rejectTransaction'])->name('admin.transactions.reject');


// routes/web.php


Route::get('/my-courses', [UserController::class, 'myCourses'])->name('user.my-courses')->middleware('auth');
Route::get('/courses/{course}/materials', [CourseController::class, 'showMaterials'])->name('courses.materials');




Route::get('/admin/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
Route::post('/admin/assignments', [AssignmentController::class, 'store'])->name('assignments.store');


// routes/web.php

Route::get('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit')->middleware('auth');
Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'storeSubmission'])->name('assignments.storeSubmission')->middleware('auth');



Route::middleware(['auth', 'role:instructor'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('assignments', AssignmentController::class);
    Route::get('submissions', [SubmissionController::class, 'review'])->name('submissions.index');
    Route::post('submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
});

Route::middleware(['auth', 'role:student'])->prefix('user')->name('user.')->group(function () {
    Route::get('assignments', [SubmissionController::class, 'index'])->name('assignments.index');
    Route::get('assignments/{id}/submit', [SubmissionController::class, 'create'])->name('assignments.submit');
    Route::post('assignments/{id}/submit', [SubmissionController::class, 'store'])->name('assignments.store');
});




Route::get('feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');

Route::resource('feedback', FeedbackController::class);

// User routes
Route::middleware('auth')->group(function () {
    Route::get('feedback/user/{id}', [FeedbackController::class, 'showForUser'])->name('feedback.user');
});
