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
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\OverseerController;
use App\Http\Controllers\PublicOverseerController;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\Admin\PastoralTeamController;
use App\Http\Controllers\PublicPastoralTeamController;


// -------------------- PUBLIC ROUTES --------------------

//PUBLIC ROUTE FOR OVERSEERS
Route::get('/church-overseers', [PublicOverseerController::class, 'index'])
     ->name('church.overseers');
     Route::prefix('pastoral-teams')->name('public.pastoral-teams.')->group(function () {
    Route::get('/district/{district}', [PublicPastoralTeamController::class, 'byDistrict'])
         ->name('by-district');
});

// --- Announcements Section ---
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
//public livestream
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

//AI CHATBOX
Route::post('/ai-chat', [AIChatController::class, 'chat']);
// -------------------- ADMIN ROUTES --------------------
Route::prefix('admin')->name('admin.')->group(function () {

    // Login & logout
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'is_admin'])->group(function () {

        // Dashboard route
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
      
     // ---------------- Hero Theme & Scripture ----------------
    Route::get('hero', [HeroController::class, 'index'])->name('hero.index');
    Route::get('hero/create', [HeroController::class, 'create'])->name('hero.create');
    Route::post('hero', [HeroController::class, 'store'])->name('hero.store');
    Route::get('hero/{id}/edit', [HeroController::class, 'edit'])->name('hero.edit');
    Route::put('hero/{id}', [HeroController::class, 'update'])->name('hero.update');

    // ---------------- Hero Slides ----------------
    Route::get('hero-slides/create', [HeroSlideController::class, 'create'])->name('hero-slides.create');
    Route::post('hero-slides', [HeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::get('hero-slides/{id}/edit', [HeroSlideController::class, 'edit'])->name('hero-slides.edit');
    Route::put('hero-slides/{id}', [HeroSlideController::class, 'update'])->name('hero-slides.update');
    Route::delete('hero-slides/{id}', [HeroSlideController::class, 'destroy'])->name('hero-slides.destroy');

    // ... other admin routes ...

        
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

    // Announcements CRUD like devotions
    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AdminAnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AdminAnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AdminAnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}', [AdminAnnouncementController::class, 'show'])->name('show');
        Route::get('/{announcement}/edit', [AdminAnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [AdminAnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('destroy');
    });

// Overseers CRUD like Announcements
Route::prefix('overseers')->name('overseers.')->group(function () {
    Route::get('/', [OverseerController::class, 'index'])->name('index');
    Route::get('/create', [OverseerController::class, 'create'])->name('create');
    Route::post('/', [OverseerController::class, 'store'])->name('store');
    Route::get('/{overseer}', [OverseerController::class, 'show'])->name('show');
    Route::get('/{overseer}/edit', [OverseerController::class, 'edit'])->name('edit');
    Route::put('/{overseer}', [OverseerController::class, 'update'])->name('update');
    Route::delete('/{overseer}', [OverseerController::class, 'destroy'])->name('destroy');

});

// Super admin:
Route::prefix('admins')->middleware(['auth', 'super_admin'])->name('admins.')->group(function () {

    // List admins
    Route::get('/', [AdminController::class, 'listAdmins'])->name('list');

    // Create admin
    Route::get('/create', [AdminController::class, 'createAdmin'])->name('create');
    Route::post('/', [AdminController::class, 'storeAdmin'])->name('store');

    // Show form to reset a regular admin's password
    Route::get('{admin}/reset-password', [AdminController::class, 'showResetPasswordForm'])->name('reset_password.form');

    // Submit new password for a regular admin
    Route::post('{admin}/reset-password', [AdminController::class, 'updateAdminPassword'])->name('reset_password.update');

    // Reset super admin's own password (show form + submit)
    Route::get('/reset-my-password', [AdminController::class, 'showResetMyPasswordForm'])->name('reset_my_password.form');
    Route::post('/reset-my-password', [AdminController::class, 'resetMyPassword'])->name('reset_my_password.submit');
});

// APastoral Team CRUD
Route::prefix('pastoral-teams')->name('pastoral-teams.')->group(function () {

    Route::get('/', [PastoralTeamController::class, 'index'])->name('index');

    Route::get('/create', [PastoralTeamController::class, 'create'])->name('create');

    Route::post('/', [PastoralTeamController::class, 'store'])->name('store');

    Route::get('/{pastoral_team}', [PastoralTeamController::class, 'show'])->name('show');

    Route::get('/{pastoral_team}/edit', [PastoralTeamController::class, 'edit'])->name('edit');

    Route::put('/{pastoral_team}', [PastoralTeamController::class, 'update'])->name('update');

    Route::delete('/{pastoral_team}', [PastoralTeamController::class, 'destroy'])->name('destroy');

});

});


