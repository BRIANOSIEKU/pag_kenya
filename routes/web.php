<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChurchProfileController;
use App\Http\Controllers\LeadershipController;
use App\Http\Controllers\PublicLeadershipController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\DepartmentAchievementController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicDevotionsController;
use App\Http\Controllers\PublicPartnerController;
use App\Http\Controllers\ProjectPublicController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DonationInstructionController;
use App\Http\Controllers\PublicDonationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\LiveStreamController;

// -------------------- PUBLIC ROUTES --------------------
// Floating / public chat
Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/fetch', [ChatController::class, 'fetch'])->name('fetch'); // fetch messages
    Route::post('/send', [ChatController::class, 'send'])->name('send');   // send message
});

// Public chat routes
Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/fetch', [\App\Http\Controllers\ChatController::class, 'fetch'])->name('fetch');
    Route::post('/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('send');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/church-profile', function () {
    $profile = \App\Models\ChurchProfile::first();
    return view('pages.church-profile', compact('profile'));
})->name('church.profile');
Route::get('/leadership/{type}', [PublicLeadershipController::class, 'index'])->name('leadership.public');
Route::get('/hq-staff', [LeadershipController::class, 'hqPublic'])->name('hq.staff.public');
Route::get('/departments/{department}', [DepartmentController::class, 'publicShow'])->name('departments.public.show');
Route::get('/news', [NewsController::class, 'publicIndex'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'publicShow'])->name('news.show');
Route::get('/devotions', [PublicDevotionsController::class, 'index'])->name('devotions.public.index');
Route::get('/devotions/{id}', [PublicDevotionsController::class, 'show'])->name('devotions.public.show');
Route::middleware('auth')->group(function () {
    Route::post('/devotions/{devotion}/comment', [\App\Http\Controllers\DevotionCommentController::class, 'store'])
        ->name('devotions.comment.store');
});
Route::get('/projects', [ProjectPublicController::class, 'index'])->name('projects.public.index');
Route::get('/projects/{project}', [ProjectPublicController::class, 'show'])->name('projects.public.show');
Route::get('/partners', [PublicPartnerController::class, 'index'])->name('partners.index');
Route::get('/partners/{id}', [PublicPartnerController::class, 'show'])->name('partners.show');
Route::get('/giving', [PublicDonationController::class, 'index'])->name('giving.public');
Route::get('/giving/submit', [PublicDonationController::class, 'showForm'])->name('giving.form');
Route::post('/giving/submit', [PublicDonationController::class, 'submitDonation'])->name('giving.submit');
Route::get('/contact', [PublicContactController::class, 'index'])->name('contact.public');

// -------------------- GOOGLE AUTH --------------------
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// -------------------- ADMIN ROUTES --------------------
Route::prefix('admin')->name('admin.')->group(function () {

    // ---------------- Login & Logout ----------------
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout'); // POST-only logout

    // ---------------- Protected Admin Routes ----------------
    Route::middleware(['auth', 'is_admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // ... other admin routes ...
    });

        // Church Profile CRUD
        Route::prefix('church-profile')->name('church-profile.')->group(function () {
            Route::get('/', [ChurchProfileController::class, 'index'])->name('index');
            Route::get('/create', [ChurchProfileController::class, 'create'])->name('create');
            Route::post('/', [ChurchProfileController::class, 'store'])->name('store');
            Route::get('/{id}', [ChurchProfileController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ChurchProfileController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ChurchProfileController::class, 'update'])->name('update');
        });

        // Leadership CRUD
        Route::prefix('leadership')->name('leadership.')->group(function () {
            Route::get('/{type}', [LeadershipController::class, 'index'])->name('index');
            Route::get('/{type}/create', [LeadershipController::class, 'create'])->name('create');
            Route::post('/{type}', [LeadershipController::class, 'store'])->name('store');
            Route::get('/{type}/{id}/edit', [LeadershipController::class, 'edit'])->name('edit');
            Route::put('/{type}/{id}', [LeadershipController::class, 'update'])->name('update');
            Route::delete('/{type}/{id}', [LeadershipController::class, 'destroy'])->name('destroy');
        });

        // Departments CRUD
        Route::prefix('departments')->name('departments.')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('index');
            Route::get('/create', [DepartmentController::class, 'create'])->name('create');
            Route::post('/', [DepartmentController::class, 'store'])->name('store');
            Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
            Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
            Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
            Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');

            Route::post('/{department}/upload-document', [DepartmentController::class, 'uploadDocument'])->name('uploadDocument');
            Route::delete('/documents/{document}', [DepartmentController::class, 'deleteDocument'])->name('deleteDocument');
            Route::post('/{department}/achievements', [DepartmentAchievementController::class, 'store'])->name('achievements.store');
            Route::delete('/achievements/{achievement}', [DepartmentAchievementController::class, 'destroy'])->name('achievements.destroy');
        });

        // Admin News
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('index');
            Route::get('/create', [NewsController::class, 'create'])->name('create');
            Route::post('/', [NewsController::class, 'store'])->name('store');
            Route::get('/{news}', [NewsController::class, 'show'])->name('show');
            Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
            Route::put('/{news}', [NewsController::class, 'update'])->name('update');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
            Route::delete('/photo/{photo}', [NewsController::class, 'destroyPhoto'])->name('photo.destroy');
        });

        // Admin Devotions
        Route::prefix('devotions')->name('devotions.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DevotionController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\DevotionController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\DevotionController::class, 'store'])->name('store');
            Route::get('/{devotion}', [\App\Http\Controllers\Admin\DevotionController::class, 'show'])->name('show');
            Route::get('/{devotion}/edit', [\App\Http\Controllers\Admin\DevotionController::class, 'edit'])->name('edit');
            Route::put('/{devotion}', [\App\Http\Controllers\Admin\DevotionController::class, 'update'])->name('update');
            Route::delete('/{devotion}', [\App\Http\Controllers\Admin\DevotionController::class, 'destroy'])->name('destroy');
        });

        // Admin Projects
        Route::prefix('projects')->name('projects.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('store');
            Route::get('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'show'])->name('show');
            Route::get('/{project}/edit', [\App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('edit');
            Route::put('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('update');
            Route::delete('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('destroy');
        });

        // Admin Partners
        Route::prefix('partners')->name('partners.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PartnerController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\PartnerController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\PartnerController::class, 'store'])->name('store');
            Route::get('/{partner}', [\App\Http\Controllers\Admin\PartnerController::class, 'show'])->name('show');
            Route::get('/{partner}/edit', [\App\Http\Controllers\Admin\PartnerController::class, 'edit'])->name('edit');
            Route::put('/{partner}', [\App\Http\Controllers\Admin\PartnerController::class, 'update'])->name('update');
            Route::delete('/{partner}', [\App\Http\Controllers\Admin\PartnerController::class, 'destroy'])->name('destroy');
        });

        // Admin Donations
        Route::prefix('donations')->name('donations.')->group(function () {
            Route::get('/', [DonationController::class, 'index'])->name('index');
            Route::get('/create', [DonationController::class, 'create'])->name('create');
            Route::post('/', [DonationController::class, 'store'])->name('store');
            Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
            Route::get('/{donation}/edit', [DonationController::class, 'edit'])->name('edit');
            Route::put('/{donation}', [DonationController::class, 'update'])->name('update');
            Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy');
        });

        // Contact Info
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/create', [ContactController::class, 'create'])->name('create');
            Route::post('/', [ContactController::class, 'store'])->name('store');
            Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
            Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
            Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
        });

// ------------------ COMMENTS MODERATION ------------------
Route::prefix('comments')->name('comments.')->group(function () {

    // Comments moderation page
    Route::get('/', [AdminCommentController::class, 'index'])
        ->name('index');

    // Reply/update comment
    Route::post('/respond/{id}', [AdminCommentController::class, 'respond'])
        ->name('respond');

    // Delete comment
    Route::delete('/delete/{id}', [AdminCommentController::class, 'destroy'])
        ->name('delete');

});

// =================== ADMIN LIVE STREAM ROUTES ===================
// Admin LiveStreams CRUD
    Route::prefix('livestreams')->name('livestreams.')->group(function () {
        Route::get('/', [LiveStreamController::class, 'index'])->name('index');
        Route::get('/create', [LiveStreamController::class, 'create'])->name('create');
        Route::post('/', [LiveStreamController::class, 'store'])->name('store');
        Route::get('/{livestream}/edit', [LiveStreamController::class, 'edit'])->name('edit');
        Route::put('/{livestream}', [LiveStreamController::class, 'update'])->name('update');
        Route::delete('/{livestream}', [LiveStreamController::class, 'destroy'])->name('destroy');

        Route::post('/{livestream}/set-active', [LiveStreamController::class, 'setActive'])->name('setActive');

        // optional show route (details page)
        Route::get('/{livestream}', [LiveStreamController::class, 'show'])->name('show');
    });
});

