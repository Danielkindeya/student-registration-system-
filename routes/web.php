<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;

// Public Pages Route Group
Route::controller(PageController::class)->group(function () {
    // Index (Homepage)
    Route::get('/', 'index')->name('home');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Payment Routes
Route::get('/register-payment', [PaymentController::class, 'showRegistrationPaymentForm'])->name('show.registration.payment');
Route::post('/process-registration-payment', [PaymentController::class, 'processRegistrationPayment'])->name('process.registration.payment');
Route::get('/receipt/{paymentId}', [PaymentController::class, 'showReceipt'])->name('receipt.show');
Route::get('/receipt/{receiptId}/download', [PaymentController::class, 'downloadReceipt'])->name('receipt.download');


// Student routes
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/edit-profile', [StudentController::class, 'editProfile'])->name('student.edit-profile');
    Route::put('/student/update-profile', [StudentController::class, 'updateProfile'])->name('student.update-profile');
    Route::get('/student/enrolled-courses', [StudentController::class, 'enrolledCourses'])->name('student.enrolled-courses');
    Route::get('/student/available-courses', [StudentController::class, 'availableCourses'])->name('student.available-courses');
    Route::post('/student/enroll/{courseId}', [StudentController::class, 'enrollInCourse'])->name('student.enroll');
    Route::get('/student/course/{course}/payment', [PaymentController::class, 'showCoursePaymentForm'])->name('student.course.payment');
    Route::post('/student/course/{course}/payment', [PaymentController::class, 'processCoursePayment'])->name('process.course.payment');

});

