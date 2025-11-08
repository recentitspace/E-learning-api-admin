<?php

use Illuminate\Support\Facades\Route;
use Modules\LMS\Http\Controllers\Student\ReviewController;
use Modules\LMS\Http\Controllers\Student\StudentController;
use Modules\LMS\Http\Controllers\Student\SupportController;
use Modules\LMS\Http\Controllers\Student\NotificationController;

Route::group(
    ['prefix' => 'dashboard', 'as' => 'student.', 'middleware' => ['auth', 'checkAuthCookie', 'role:Student', 'checkInstaller']],
    function () {

        Route::group(['controller' => StudentController::class], function () {
            Route::get('/', 'dashboard')->name('dashboard');
            Route::post('logout', 'logout')->name('logout');
            Route::get('my-enrolled-course', 'allCourse')->name('enroll.index');
            Route::get('purchase-course', 'purchaseCourse')->name('purchase.index');
            Route::get('bundle-course', 'bundleCourse')->name('bundle.index');
            Route::get('certificate', 'certificate')->name('certificate.index');
            Route::get('quizzes/my-result', 'quizResult')->name('quiz.result');
            Route::get('assignments', 'assignmentList')->name('assignment.list');
            Route::get("request/certificate/{id}", 'certificateGenerate')->name('generate.certificate');
            Route::get("certificate/view/{id}", 'certificateDownload')->name('certificate.download');
            Route::get("wishlists", 'wishlists')->name('wishlist');
            Route::get("offline/payment", 'offlinePayment')->name('offline.payment');
            Route::delete('wishlists/{id}', 'removeWishlist')->name('remove.wishlist');
        });

        Route::group(['controller' => NotificationController::class], function () {
            Route::get('notification', 'history')->name('notification.history');
            Route::get('notification/read/{id}', 'notificationHistoryStatus')->name('notification.history.status');
            Route::delete('notification/delete/{id}', 'notificationHistoryDelete')->name('notification.history.delete');
            Route::get('notification/read-all', 'notificationReadAll')->name('notification.read.all');
        });
        Route::resource('supports', SupportController::class);
        Route::get('course-support', [SupportController::class, 'courseSupport'])->name('course.support.index');
        Route::get('course-support-create', [SupportController::class, 'courseSupportCreate'])->name('course.support.create');
        Route::get('reply/{id}', [SupportController::class, 'reply'])->name('reply');
        Route::post('ticket-reply', [SupportController::class, 'ticketReply'])->name('ticket.reply');
        Route::post('ticket-close/{ticket_id}', [SupportController::class, 'ticketClose'])->name('ticket.close');

        Route::group(['prefix' => 'review'], function () {
            Route::resource('course-review', ReviewController::class)->except('destroy', 'edit', 'show');
        });
    }
);
