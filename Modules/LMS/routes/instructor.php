<?php

use Illuminate\Support\Facades\Route;
use Modules\LMS\Http\Controllers\Instructor\SaleController;
use Modules\LMS\Http\Controllers\Instructor\PayoutController;
use Modules\LMS\Http\Controllers\Instructor\ReviewController;
use Modules\LMS\Http\Controllers\Instructor\SettingController;
use Modules\LMS\Http\Controllers\Instructor\SupportController;
use Modules\LMS\Http\Controllers\Admin\Courses\ChapterController;
use Modules\LMS\Http\Controllers\Instructor\InstructorController;
use Modules\LMS\Http\Controllers\Instructor\Courses\TagController;
use Modules\LMS\Http\Controllers\Instructor\NoticesBoardController;
use Modules\LMS\Http\Controllers\Instructor\NotificationController;
use Modules\LMS\Http\Controllers\Admin\Localization\StateController;
use Modules\LMS\Http\Controllers\Instructor\Courses\CourseController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizController;
use Modules\LMS\Http\Controllers\Admin\Courses\Topics\TopicController;
use Modules\LMS\Http\Controllers\Admin\Localization\CountryController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuestionController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizTypeController;
use Modules\LMS\Http\Controllers\Instructor\Courses\Bundle\BundleController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizQuestionController;

Route::group(
    ['prefix' => 'instructor', 'as' => 'instructor.', 'middleware' => ['auth:web', 'checkAuthCookie', 'role:Instructor', 'checkInstaller']],
    function () {

        Route::get('/', [InstructorController::class, 'index'])->name('dashboard');
        Route::post('logout/', [InstructorController::class, 'logout'])->name('logout');
        Route::get('students/', [InstructorController::class, 'students'])->name('student.list');
        Route::get('students/profile/{id}', [InstructorController::class, 'profile'])->name('student.profile');
        Route::get('searching-suggestion', [InstructorController::class, 'searchingSuggestion'])->name('searching.suggestion');
        Route::get('assignments', [InstructorController::class, 'courseAssignments'])->name('assignments');
        Route::get('assignments/{assignment_id}/students', [InstructorController::class, 'studentAssignments'])->name('student.assignment');
        Route::post('assignment/mark/{id}', [InstructorController::class, 'assignmentMark'])->name('assignment.mark');
        Route::get("wishlists", [InstructorController::class, 'wishlists'])->name('wishlist');
        Route::delete('wishlists/{id}',  [InstructorController::class, 'removeWishlist'])->name('remove.wishlist');

        /*  Notification */

        Route::get('notification', [NotificationController::class, 'history'])->name('notification.history');
        Route::get('notification/read/{id}', [NotificationController::class, 'notificationHistoryStatus'])->name('notification.history.status');
        Route::delete('notification/delete/{id}', [NotificationController::class, 'notificationHistoryDelete'])->name('notification.history.delete');
        Route::get('notification/read-all', [NotificationController::class, 'notificationReadAll'])->name('notification.read.all');

        /* supports */
        Route::resource('supports', SupportController::class);
        Route::get('reply/{id}', [SupportController::class, 'reply'])->name('reply');
        Route::post('ticket-reply', [SupportController::class, 'ticketReply'])->name('ticket.reply');
        Route::post('ticket-close/{ticket_id}', [SupportController::class, 'ticketClose'])->name('ticket.close');
        Route::get('student-support', [SupportController::class, 'studentSupport'])->name('student.support');
        Route::get('student-support-reply/{id}', [SupportController::class, 'studentSupportReply'])->name('student.support.reply');


        /* course */

        Route::resource('course', CourseController::class)->except('show');
        Route::put('course/restore/{id}', [CourseController::class, 'restore'])->name('course.restore');
        Route::get('course/{id}/translate/{locale}', [CourseController::class, 'translate'])->name('course.translate');


        Route::prefix('course')->group(
            function () {
                Route::get('delete-information', [CourseController::class, 'deleteInformation'])->name('course.delete.information');
                Route::get('multiple-image-remove/{id}', [CourseController::class, 'deleteImage'])->name('course.multiple.image.delete');
                Route::resource('chapter', ChapterController::class);
                Route::get('chapter-sorted', [ChapterController::class, 'chapterSorted'])->name('chapter.sorted');
                Route::resource('topic', TopicController::class);
                Route::get('assignment-file-delete/{id}', [TopicController::class, 'assignmentFileDelete'])->name('assignment.file.delete');
                Route::get('topic-sorted', [TopicController::class, 'topicSorted'])->name('topic.sorted');
                Route::get('chapter-topic-type/{type}', [TopicController::class, 'topicType'])->name('chapter.topic.type');
                Route::resource('bundle', BundleController::class);
                Route::put('bundle/restore/{id}', [BundleController::class, 'restore'])->name('bundle.restore');
                Route::get('bundle/{id}/translate/{locale}', [BundleController::class, 'translate'])->name('bundle.translate');
                Route::delete('bundle/thumbnail-delete/{id}', [BundleController::class, 'thumbnailDelete'])->name('bundle.thumbnail.delete');
                Route::resource('tag', TagController::class)->only('store');
                Route::get('tag-search', [CourseController::class, 'tagSearch']);
            }
        );

        /*quizzes */
        Route::prefix('quizzes')->group(
            function () {
                Route::resource('quiz-type', QuizTypeController::class);
                Route::resource('question', QuestionController::class);
                Route::resource('answer', QuestionController::class);
                Route::resource('quiz', QuizController::class)->names('quiz');
                Route::resource('quiz-question', QuizQuestionController::class);
                Route::get('quiz-question-sorted', [QuizQuestionController::class, 'quizQuestionSorted']);
                Route::get('searching-suggestion', [QuizQuestionController::class, 'searchingSuggestion']);
                Route::get('/', [QuizController::class, 'quizList'])->name('quiz.list');
                Route::get('{quiz_id}/students', [QuizController::class, 'studentQuizzes'])->name('student.quiz');
            }
        );


        Route::group(
            ['prefix' => 'financial'],
            function () {
                Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
                Route::get('payout', [PayoutController::class, 'index'])->name('payout.index');
                Route::post('payout', [PayoutController::class, 'payoutRequest'])->name('payout.request');
            }
        );
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::post('profile', [SettingController::class, 'updateProfile'])->name('profile.update');
        Route::get('skill-remove/{id}', [SettingController::class, 'removeSkill'])->name('skill.remove');
        Route::get('delete-info-setting/{type}/{id}', [SettingController::class, 'settingInformationUser'])->name('setting.info.delete');

        /* localization */
        Route::prefix('localization')->group(
            function () {
                Route::get('country-status-change/{id}', [CountryController::class, 'statusChange'])->name('country.status');
                Route::get('country-state/{id}', [CountryController::class, 'stateGetByCountry'])->name('country.state');
                Route::get('state-city/{id}', [StateController::class, 'cityGetByState']);
            }
        );

        Route::group(
            ['prefix' => 'review'],
            function () {
                Route::resource('course-review', ReviewController::class);
            }
        );
        /* Notification */
        Route::resource('noticeboard', NoticesBoardController::class);
    }
);
