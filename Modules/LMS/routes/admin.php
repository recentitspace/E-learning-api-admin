<?php

use Illuminate\Support\Facades\Route;
use Modules\LMS\Http\Controllers\Admin\FaqController;
use Modules\LMS\Http\Controllers\Admin\PageController;
use Modules\LMS\Http\Controllers\Admin\ThemeController;
use Modules\LMS\Http\Controllers\Openai\OpenaiController;
use Modules\LMS\Http\Controllers\Admin\CurrencyController;
use Modules\LMS\Http\Controllers\Admin\LanguageController;
use Modules\LMS\Http\Controllers\Admin\UserTypeController;
use Modules\LMS\Http\Controllers\Admin\Blog\BlogController;
use Modules\LMS\Http\Controllers\Admin\DashboardController;
use Modules\LMS\Http\Controllers\Admin\Hero\HeroController;
use Modules\LMS\Http\Controllers\Admin\EnrollmentController;
use Modules\LMS\Http\Controllers\Admin\Courses\TagController;
use Modules\LMS\Http\Controllers\Admin\Forum\ForumController;
use Modules\LMS\Http\Controllers\Admin\NotificationController;
use Modules\LMS\Http\Controllers\Admin\ThemeSettingController;
use Modules\LMS\Http\Controllers\Admin\Coupon\CouponController;
use Modules\LMS\Http\Controllers\Admin\Courses\LevelController;
use Modules\LMS\Http\Controllers\Admin\PaymentMethodController;
use Modules\LMS\Http\Controllers\Admin\Review\ReviewController;
use Modules\LMS\Http\Controllers\Admin\Slider\SliderController;
use Modules\LMS\Http\Controllers\Admin\Courses\CourseController;
use Modules\LMS\Http\Controllers\Admin\Financial\SaleController;
use Modules\LMS\Http\Controllers\Admin\Forum\SubForumController;
use Modules\LMS\Http\Controllers\Admin\Contact\ContactController;
use Modules\LMS\Http\Controllers\Admin\Courses\ChapterController;
use Modules\LMS\Http\Controllers\Admin\Courses\SubjectController;
use Modules\LMS\Http\Controllers\Admin\Student\StudentController;
use Modules\LMS\Http\Controllers\Admin\Courses\OutcomesController;
use Modules\LMS\Http\Controllers\Admin\Financial\PayoutController;
use Modules\LMS\Http\Controllers\Admin\Blog\BlogCategoryController;
use Modules\LMS\Http\Controllers\Admin\Category\CategoryController;
use Modules\LMS\Http\Controllers\Admin\Courses\TopicTypeController;
use Modules\LMS\Http\Controllers\Admin\Localization\CityController;
use Modules\LMS\Http\Controllers\Admin\IconProviders\IconController;
use Modules\LMS\Http\Controllers\Admin\Localization\StateController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizController;
use Modules\LMS\Http\Controllers\Admin\Courses\Topics\TopicController;
use Modules\LMS\Http\Controllers\Admin\Localization\CountryController;
use Modules\LMS\Http\Controllers\Admin\Courses\Bundle\BundleController;
use Modules\LMS\Http\Controllers\Admin\General\EmailTemplateController;
use Modules\LMS\Http\Controllers\Admin\Instructor\InstructorController;
use Modules\LMS\Http\Controllers\Admin\Localization\TimeZoneController;
use Modules\LMS\Http\Controllers\Admin\Certificate\CertificateController;
use Modules\LMS\Http\Controllers\Admin\Testimonial\TestimonialController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuestionController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizTypeController;
use Modules\LMS\Http\Controllers\Admin\Noticeboard\NoticesBoardController;
use Modules\LMS\Http\Controllers\Admin\MeetProvider\MeetProviderController;
use Modules\LMS\Http\Controllers\Admin\Organization\OrganizationController;
use Modules\LMS\Http\Controllers\Admin\SupportTicket\TicketSupportController;
use Modules\LMS\Http\Controllers\Admin\Courses\Quizzes\QuizQuestionController;
use Modules\LMS\Http\Controllers\Admin\PaymentController;
use Modules\LMS\Http\Controllers\Admin\SupportTicket\SupportCategoryController;


Route::group(
    ['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkAuthCookie', 'checkInstaller']],
    function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [DashboardController::class, 'profileUpdate'])->name('admin.profile.update');

        Route::get('/cache-clear', [DashboardController::class, 'cacheClear'])->name('cache.clear');
        Route::get('/cache-optimize', [DashboardController::class, 'cacheOptimize'])->name('cache.optimize');
        Route::get('/storage-link', [DashboardController::class, 'storageLink'])->name('storage.link');
        Route::get('license-remove', [DashboardController::class, 'licenseRemoveForm'])->name('license.remove.index');
        Route::post('license-remove', [DashboardController::class, 'licenseRemove'])->name('license.remove');

        Route::get('license-update', [DashboardController::class, 'licenseUpdateForm'])->name('license.update.form');
        Route::post('license-update', [DashboardController::class, 'licenseUpdate'])->name('license.update');

        Route::get('lms-module/{name}', [DashboardController::class, 'lmsModule'])->name('lms.module');



        Route::post('logout', [DashboardController::class, 'logout'])->name('admin.logout');
        Route::get('searching-suggestion', [DashboardController::class, 'searchingSuggestion'])->name('searching.suggestion');

        Route::get('assets', [DashboardController::class, 'assetsPath'])->name('theme.asset');

        Route::resource('language', LanguageController::class);
        Route::put('language/restore/{id}', [LanguageController::class, 'restore'])->name('language.restore');
        Route::get('translate/{id}', [LanguageController::class, 'translate'])->name('translate');
        Route::post('language/store/{id}', [LanguageController::class, 'translateStore'])->name('translate.store');
        Route::get('language/default-change/{id}', [LanguageController::class, 'defaultChange'])->name('language.default');
        Route::get('language/status-change/{id}', [LanguageController::class, 'statusChange'])->name('language.status');
        Route::get('language/rtl-active/{id}', [LanguageController::class, 'rtlActive'])->name('language.rtl');

        Route::prefix('theme')->group(
            function () {
                Route::get('/', [ThemeController::class, 'index'])->name('theme.index');
                Route::post('install', [ThemeController::class, 'install'])->name('theme.install');
                Route::post('activate', [ThemeController::class, 'activate'])->name('theme.activate');
            }
        );

        Route::prefix('localization')->group(
            function () {

                Route::resource('country', CountryController::class);
                Route::put('country/restore/{id}', [CountryController::class, 'restore'])->name('country.restore');
                Route::get('country-status-change/{id}', [CountryController::class, 'statusChange'])->name('country.status');
                Route::get('country-state/{id}', [CountryController::class, 'stateGetByCountry'])->name('country.state');
                Route::get('country/{id}/translate/{locale}', [CountryController::class, 'edit'])->name('country.translate');

                Route::resource('state', StateController::class);
                Route::put('state/restore/{id}', [StateController::class, 'restore'])->name('state.restore');
                Route::get('state-city/{id}', [StateController::class, 'cityGetByState']);
                Route::get('state-status-change/{id}', [StateController::class, 'statusChange'])->name('state.status');
                Route::get('state/{id}/translate/{locale}', [StateController::class, 'edit'])->name('state.translate');

                Route::resource('city', CityController::class);
                Route::put('city/restore/{id}', [CityController::class, 'restore'])->name('city.restore');
                Route::get('city-status-change/{id}', [CityController::class, 'statusChange'])->name('city.status');
                Route::get('city/{id}/translate/{locale}', [CityController::class, 'edit'])->name('city.translate');

                Route::resource('time-zone', TimeZoneController::class);
                Route::put('time-zone/restore/{id}', [TimeZoneController::class, 'restore'])->name('time-zone.restore');
                Route::get('time-zone-status-change/{id}', [TimeZoneController::class, 'statusChange'])->name('timezone.status');
                Route::get('time-zone/{id}/translate/{locale}', [TimeZoneController::class, 'edit'])->name('timezone.translate');
            }
        );

        Route::prefix('icon-providers')->group(
            function () {
                Route::resource('icon', IconController::class);
                Route::put('icon/restore/{id}', [IconController::class, 'restore'])->name('icon.restore');
                Route::get('icon/status-change/{id}', [IconController::class, 'statusChange'])->name('icon.status');
            }
        );

        Route::resource('category', CategoryController::class);
        Route::get('category/{id}/translate/{locale}', [CategoryController::class, 'edit'])->name('category.translate');
        Route::put('category/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::get('category/status-change/{id}', [CategoryController::class, 'statusChange'])->name('category.status');

        /** course **/
        Route::resource('course', CourseController::class)->except('show');
        Route::get('course/{id}/translate/{locale}', [CourseController::class, 'translate'])->name('course.translate');
        Route::put('course/restore/{id}', [CourseController::class, 'restore'])->name('course.restore');

        Route::resource('subject', SubjectController::class);
        Route::get('subject/{id}/translate/{locale}', [SubjectController::class, 'edit'])->name('subject.translate');
        Route::put('subject/restore/{id}', [SubjectController::class, 'restore'])->name('subject.restore');

        Route::prefix('course')->group(
            function () {
                Route::resource('tag', TagController::class);
                Route::get('tag/{id}/translate/{locale}', [TagController::class, 'edit'])->name('tag.translate');
                Route::resource('level', LevelController::class);
                Route::get('level/{id}/translate/{locale}', [LevelController::class, 'edit'])->name('level.translate');
                Route::put('level/restore/{id}', [LevelController::class, 'restore'])->name('level.restore');

                Route::resource('outcomes', OutcomesController::class);
                Route::get('outcomes-search', [OutcomesController::class, 'outcomesGetByQuery']);
                Route::controller(CourseController::class)->group(
                    function () {
                        Route::get('tag-search', 'tagSearch');
                        Route::get('delete-information', 'deleteInformation')->name('course.delete.information');
                        Route::get('multiple-image-remove/{id}', 'deleteImage')->name('course.multiple.image.delete');
                        Route::get('course/status-change/{id}', 'statusChange')->name('course.status');
                        Route::get('live-class', 'liveClass')->name('course.live.class');
                    }
                );
                Route::resource('chapter', ChapterController::class);
                Route::get('chapter-sorted', [ChapterController::class, 'chapterSorted'])->name('chapter.sorted');
                Route::resource('topic-type', TopicTypeController::class)->except('index');
                Route::resource('topic', TopicController::class);
                Route::get('assignment-file-delete/{id}', [TopicController::class, 'assignmentFileDelete'])->name('assignment.file.delete');
                Route::get('topic-sorted', [TopicController::class, 'topicSorted'])->name('topic.sorted');
                Route::get('chapter-topic-type/{type}', [TopicController::class, 'topicType'])->name('chapter.topic.type');
            }
        );


        Route::prefix('course')->group(function () {
            Route::resource('bundle', BundleController::class);
            Route::put('bundle/restore/{id}', [BundleController::class, 'restore'])->name('bundle.restore');
            Route::delete('bundle/thumbnail-delete/{id}', [BundleController::class, 'thumbnailDelete'])->name('bundle.thumbnail.delete');
            Route::put('bundle/restore/{id}', [BundleController::class, 'restore'])->name('bundle.restore');
            Route::get('bundle/{id}/translate/{locale}', [BundleController::class, 'translate'])->name('bundle.translate');
            Route::get('bundle/delete-information', [BundleController::class, 'deleteInformation'])->name('bundle.delete.information');
            Route::get('bundle/status-change/{id}', [BundleController::class, 'statusChange'])->name('bundle.status');
        });

        Route::prefix('quizzes')->group(
            function () {
                Route::resource('quiz-type', QuizTypeController::class);
                Route::resource('question', QuestionController::class);
                Route::resource('answer', QuestionController::class);
                Route::resource('/', QuizController::class);
                Route::resource('quiz-question', QuizQuestionController::class);
                Route::get('quiz-question-sorted', [QuizQuestionController::class, 'quizQuestionSorted']);
                Route::get('searching-suggestion', [QuizQuestionController::class, 'searchingSuggestion']);
            }
        );

        Route::resource('currency', CurrencyController::class);
        Route::get('currency/status-change/{id}', [CurrencyController::class, 'statusChange'])->name('currency.status');

        Route::resource('user-type', UserTypeController::class);
        Route::resource('meet-provider', MeetProviderController::class);

        /** student **/
        Route::resource('students', StudentController::class)->names('student');
        Route::get('students/profile/{id}', [StudentController::class, 'profile'])->name('student.profile');
        Route::get('students/status-change/{id}', [StudentController::class, 'statusChange'])->name('student.status');
        Route::get('students/verify-email/{id}', [StudentController::class, 'verifyEmail'])->name('student.verify.email');
        Route::put('students/restore/{id}', [StudentController::class, 'restore'])->name('student.restore');
        Route::get('student/{id}/translate/{locale}', [StudentController::class, 'edit'])->name('student.translate');

        /** organization **/
        Route::resource('organizations', OrganizationController::class)->names('organization');
        Route::get('organizations/profile/{id}', [OrganizationController::class, 'profile'])->name('organization.profile');
        Route::get('organizations/status-change/{id}', [OrganizationController::class, 'statusChange'])->name('organization.status');
        Route::get('organizations/verify-email/{id}', [OrganizationController::class, 'verifyEmail'])->name('organization.verify.email');
        Route::get('organizations/search/{name}', [OrganizationController::class, 'getOrganizationName'])->name('organization.search');
        Route::get('organization-instructor/{id}', [OrganizationController::class, 'getInstructor'])->name('organization.instructors');
        Route::put('organization/restore/{id}', [OrganizationController::class, 'restore'])->name('organization.restore');
        Route::get('organization/{id}/translate/{locale}', [OrganizationController::class, 'edit'])->name('organization.translate');
        /** instructor **/
        Route::resource('instructors', InstructorController::class)->names('instructor');
        Route::get('instructors/profile/{id}', [InstructorController::class, 'profile'])->name('instructor.profile');
        Route::get('instructors/status-change/{id}', [InstructorController::class, 'statusChange'])->name('instructor.status');
        Route::get('instructors/verify-email/{id}', [InstructorController::class, 'verifyEmail'])->name('instructor.verify.email');
        Route::put('instructor/restore/{id}', [InstructorController::class, 'restore'])->name('instructor.restore');
        Route::get('instructor/{id}/translate/{locale}', [InstructorController::class, 'edit'])->name('instructor.translate');
        /** marketing **/
        Route::group(
            ['prefix' => 'marketing'],
            function () {
                Route::resource('coupon', CouponController::class);
                Route::get('coupon/status-change/{id}', [CouponController::class, 'statusChange'])->name('coupon.status');
            }
        );

        Route::group(
            ['prefix' => 'financial'],
            function () {
                Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
                Route::get('payout-request', [PayoutController::class, 'index'])->name('request.payout');
                Route::get('payout/status-change/{id}', [PayoutController::class, 'statusChange'])->name('payout.status');
                Route::get('invoice/{id}', [SaleController::class, 'invoice'])->name('sale.invoice');
                Route::get('offline', [PaymentController::class, 'offlinePayment'])->name('offline.payment');
                Route::get('offline/status/{id}', [PaymentController::class, 'changePaymentStatus'])->name('offline.status');
            }
        );
        /** testimonial **/
        Route::resource('testimonial', TestimonialController::class);
        Route::get('testimonial/{id}/translate/{locale}', [TestimonialController::class, 'edit'])->name('testimonial.translate');
        Route::put('testimonial/restore/{id}', [TestimonialController::class, 'restore'])->name('testimonial.restore');
        Route::get('testimonial/status-change/{id}', [TestimonialController::class, 'statusChange'])->name('testimonial.status');

        /** email Template **/
        Route::resource('email-template', EmailTemplateController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        /** blog **/
        Route::group(
            ['prefix' => 'blog', 'as' => 'blog.'],
            function () {
                Route::resource('category', BlogCategoryController::class);
                Route::get('category/{id}/translate/{locale}', [BlogCategoryController::class, 'edit'])->name('category.translate');
                Route::put('category/restore/{id}', [BlogCategoryController::class, 'restore'])->name('category.restore');
                Route::get('status-change/{id}', [BlogCategoryController::class, 'statusChange'])->name('category.change');
            }
        );
        Route::resource('blog', BlogController::class);
        Route::get('blog/{id}/translate/{locale}', [BlogController::class, 'edit'])->name('blog.translate');
        Route::put('blog/restore/{id}', [BlogController::class, 'restore'])->name('blog.restore');
        Route::get('status-change/{id}', [BlogController::class, 'statusChange'])->name('blog.status');

        /** Enrolled Users **/
        Route::group(
            ['prefix' => 'enrollment', 'as' => 'enrollment.', 'controller' => EnrollmentController::class],
            function () {
                Route::get('all', 'index')->name('index');
                Route::get('new-create', 'create')->name('create');
                Route::post('enrolled', 'enrolled')->name('store');
                Route::get('enrolled/edit/{id}', 'edit')->name('edit');
                Route::get('enrolled/show/{id}', 'show')->name('show');
                Route::delete('enrolled/destroy/{id}', 'destroy')->name('destroy');
            }
        );

        /** contact **/
        Route::group(['prefix' => 'contact', 'as' => 'contact.', 'controller' => ContactController::class],   function () {
            Route::get('/', 'index')->name('index');
            Route::get('reply/{id}', 'view')->name('view');
            Route::post('reply', 'reply')->name('reply');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });
        /** noticeboard **/
        Route::resource('noticeboard', NoticesBoardController::class);

        /** notification **/
        Route::resource('notification', NotificationController::class)->except('show');
        Route::get('notification/history', [NotificationController::class, 'history'])->name('notification.history');
        Route::get('notification/read/{id}', [NotificationController::class, 'notificationHistoryStatus'])->name('notification.history.status');
        Route::delete('notification/delete/{id}', [NotificationController::class, 'notificationHistoryDelete'])->name('notification.history.delete');
        Route::get('notification/read-all', [NotificationController::class, 'notificationReadAll'])->name('notification.read.all');

        /**  Theme Option **/
        Route::group(['prefix' => 'theme-setting', 'controller' => ThemeSettingController::class], function () {
            Route::get('/', 'index')->name('theme-setting.index');
            Route::post('theme-setting', 'themeSetting')->name('theme.setting');
            Route::post('image-upload-file', 'imageUpload')->name('theme.image.upload');
        });

        Route::resource('language', LanguageController::class);
        Route::put('language/restore/{id}', [LanguageController::class, 'restore'])->name('language.restore');
        Route::get('language/{id}/translate/{locale}', [LanguageController::class, 'edit'])->name('language.translate');


        Route::get('backend-setting', [ThemeSettingController::class,  'backendSetting'])->name('backend-setting.index');
        Route::get('site-language', [LanguageController::class, 'siteLanguage'])->name('site.language');
        Route::get('site-language/translate/{id}', [LanguageController::class, 'translate'])->name('site.language.translate');

        /**  forum **/
        Route::resource('forum', ForumController::class);
        Route::resource('sub-forum', SubForumController::class);
        Route::get('forum/status-change/{id}', [ForumController::class, 'statusChange'])->name('forum.status');

        /**  support **/
        Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
            Route::resource('category', SupportCategoryController::class);
            Route::get('category/{id}/translate/{locale}', [SupportCategoryController::class, 'edit'])->name('category.translate');
            Route::get('ticket', [TicketSupportController::class, 'index'])->name('ticket.index');
            Route::get('reply/{id}', [TicketSupportController::class, 'reply'])->name('reply');
            Route::post('ticket-reply', [TicketSupportController::class, 'ticketReply'])->name('ticket.reply');
            Route::get('delete-support-file/{id}', [TicketSupportController::class, 'deleteSupportFile'])->name('delete.file');
            Route::post('ticket-close/{ticket_id}', [TicketSupportController::class, 'ticketClose'])->name('close');
        });

        /**   Method Method **/
        Route::resource('payment-method', PaymentMethodController::class);
        Route::get('payment/status-change/{id}',  [PaymentMethodController::class, 'statusChange'])->name('payment.status');
        Route::resource('certificate', CertificateController::class);
        Route::resource('faq', FaqController::class);
        Route::resource('page', PageController::class)->only('index', 'edit', 'update');
        Route::get('translate/{id}/translate/{locale}', [PageController::class, 'edit'])->name('page.translate');

        Route::resource('hero', HeroController::class);
        Route::put('hero/restore/{id}', [HeroController::class, 'restore'])->name('hero.restore');
        Route::resource('slider', SliderController::class);
        Route::get('slider/{id}/translate/{locale}', [SliderController::class, 'edit'])->name('slider.translate');
        Route::put('slider/restore/{id}', [SliderController::class, 'restore'])->name('slider.restore');
        Route::group(['prefix' => 'review'],  function () {
            Route::resource('course-review', ReviewController::class);
        });
        Route::post('generate/completions', [OpenaiController::class, 'generate'])->name('generate.content');
    }
);
