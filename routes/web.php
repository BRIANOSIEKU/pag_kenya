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
use App\Http\Controllers\PublicPastoralTeamController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CommitteeReportController;
use App\Http\Controllers\PublicCommitteeController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DistrictLeaderController;
use App\Http\Controllers\Admin\DistrictAdminController;
use App\Http\Controllers\Auth\DistrictAdminAuthController;
use App\Http\Controllers\DistrictAdmin\DashboardController;
use App\Http\Controllers\District\DistrictAssemblyController;
use App\Http\Controllers\AssemblyLeaderController;
use App\Http\Controllers\AssemblyMemberController;
use App\Http\Controllers\DistrictAdmin\PastoralTeamController;
use App\Http\Controllers\Admin\AssemblyApprovalController;
use App\Http\Controllers\DistrictAdmin\TitheReportController;
use App\Http\Controllers\Admin\TitheReportReviewController;
use App\Http\Controllers\DistrictAdmin\PastoralTransferController;
use App\Http\Controllers\DistrictAdmin\NotificationController;
use App\Http\Controllers\Admin\TransferApprovalController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\OverseerReportController;
use App\Http\Controllers\Admin\NationalOfficeShareController;
use App\Http\Controllers\Admin\DistrictSummaryController;
use App\Http\Controllers\DistrictAdmin\PastoralTransferLetterController;
use App\Http\Controllers\Admin\NationalPastoralApprovalController;

// -------------------- PUBLIC ROUTES --------------------
//Public for Committees
Route::get('/committees/{committee}', [PublicCommitteeController::class, 'show'])
    ->name('public.committees.show');


    //-----church districts------
Route::get('/districts', [DistrictController::class, 'index'])
    ->name('public.districts.index');

Route::get('/districts/{id}', [DistrictController::class, 'show'])
    ->name('public.districts.show');
    Route::get('/districts/{id}/pastoral-team', [PublicPastoralTeamController::class, 'show'])
    ->name('public.pastoral-teams.by-district');

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

//========District Admin Authentication Routes======
// Show login page
Route::get('/district-admin/login', [DistrictAdminAuthController::class, 'showLoginForm'])
    ->name('district.admin.login');

// Process login
Route::post('/district-admin/login', [DistrictAdminAuthController::class, 'login'])
    ->name('district.admin.login.submit');

// Logout
Route::get('/district-admin/logout', [DistrictAdminAuthController::class, 'logout'])
    ->name('district.admin.logout');

//DISTRICT DASHBOARD
// -------------------- ADMIN ROUTES --------------------
Route::prefix('admin')->name('admin.')->group(function () {

    // Login & logout
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth', 'is_admin'])->group(function () {



//DISTRICT DASHBOARD
Route::get('/district-admin/dashboard', [DashboardController::class, 'index'])
    ->name('district.admin.dashboard');


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

              Route::get('/{department}/gallery', [DepartmentController::class, 'gallery'])
         ->name('gallery');

    Route::post('/{department}/gallery', [DepartmentController::class, 'uploadGallery'])
         ->name('uploadGallery');

    Route::delete('/gallery/{image}', [DepartmentController::class, 'deleteGallery'])
         ->name('deleteGallery');
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
            // STK Push endpoint
Route::post('/giving/stk-push', [PublicDonationController::class, 'initiateStkPush'])
    ->name('giving.stk-push');

// M-Pesa callback endpoint (Daraja will call this)
Route::post('/mpesa/callback', [PublicDonationController::class, 'mpesaCallback'])
    ->name('mpesa.callback');
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

//department gallery
Route::get('/admin/departments/{department}/gallery', [DepartmentController::class, 'gallery'])
     ->name('admin.departments.gallery');

Route::post('/admin/departments/{department}/gallery', [DepartmentController::class, 'uploadGallery'])
     ->name('admin.departments.uploadGallery');

Route::delete('/admin/departments/gallery/{image}', [DepartmentController::class, 'deleteGallery'])
     ->name('admin.departments.deleteGallery');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    Route::prefix('committees')->name('committees.')->group(function () {

        // ---------------- Committees CRUD ----------------
        Route::get('/', [CommitteeController::class, 'index'])->name('index');
        Route::get('/create', [CommitteeController::class, 'create'])->name('create');
        Route::post('/', [CommitteeController::class, 'store'])->name('store');
        Route::get('/{committee}/edit', [CommitteeController::class, 'edit'])->name('edit');
        Route::put('/{committee}', [CommitteeController::class, 'update'])->name('update');
        Route::delete('/{committee}', [CommitteeController::class, 'destroy'])->name('destroy');

        // ---------------- Committee Leadership ----------------
        Route::prefix('{committee}/leadership')->name('leadership')->group(function () {
            Route::get('/', [CommitteeController::class, 'leadership']);                // list all leaders
            Route::get('/create', [CommitteeController::class, 'leadershipCreate'])->name('.create');  // add new leader
            Route::post('/', [CommitteeController::class, 'storeLeadership'])->name('.store');         // store leader
            Route::get('/{leader}/edit', [CommitteeController::class, 'editLeadership'])->name('.edit'); // edit leader
            Route::put('/{leader}', [CommitteeController::class, 'updateLeadership'])->name('.update'); // update leader
            Route::delete('/{leader}', [CommitteeController::class, 'destroyLeadership'])->name('.destroy'); // delete leader
        });

        // ---------------- Committee Members ----------------
        Route::prefix('{committee}/members')->name('members.')->group(function () {
            Route::get('/', [CommitteeController::class, 'members'])->name('index');      
            Route::get('/create', [CommitteeController::class, 'createMember'])->name('create'); 
            Route::post('/', [CommitteeController::class, 'addMember'])->name('store');        
            Route::get('/{member}/edit', [CommitteeController::class, 'editMember'])->name('edit'); 
            Route::put('/{member}', [CommitteeController::class, 'updateMember'])->name('update'); 
            Route::delete('/{member}', [CommitteeController::class, 'removeMember'])->name('destroy'); 
        });

        // ---------------- Committee Duties ----------------
        Route::get('{committee}/duties', [CommitteeController::class, 'duties'])->name('duties');

        // ---------------- Committee Reports ----------------
        Route::prefix('{committee}/reports')->name('reports.')->group(function () {
            Route::get('/', [CommitteeReportController::class, 'index'])->name('index'); 
            Route::get('/create', [CommitteeReportController::class, 'create'])->name('create'); 
            Route::post('/', [CommitteeReportController::class, 'store'])->name('store'); 
            Route::get('/{report}/edit', [CommitteeReportController::class, 'edit'])->name('edit'); 
            Route::put('/{report}', [CommitteeReportController::class, 'update'])->name('update'); 
            Route::delete('/{report}', [CommitteeReportController::class, 'destroy'])->name('destroy'); 
        });

    });
 // ================= DISTRICTS =================
 // EXPORT ALL PASTORS
// =====================
Route::get('/pastors/export', 
    [App\Http\Controllers\Admin\PastoralTeamController::class, 'exportAllPastors']
)->name('pastors.export');

       // EXPORT ROUTES (FIXED LOCATION)
    Route::get('districts/export', [DistrictLeaderController::class, 'exportForm'])
        ->name('districts.export.form');

    Route::post('districts/export', [DistrictLeaderController::class, 'exportPdf'])
        ->name('districts.export.pdf');
 Route::prefix('districts')->name('districts.')->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index');
        Route::get('/create', [DistrictController::class, 'create'])->name('create');
        Route::post('/', [DistrictController::class, 'store'])->name('store');

        Route::get('/{district}/edit', [DistrictController::class, 'edit'])->name('edit');
        Route::put('/{district}', [DistrictController::class, 'update'])->name('update');
        Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy');

        // DISTRICT LEADERSHIP
        Route::get('/dashboard', [DistrictController::class, 'dashboard'])
    ->name('dashboard');
        Route::prefix('{district}/leadership')->name('leadership.')->group(function () {

            Route::get('/', [DistrictLeaderController::class, 'index'])->name('index');
            Route::get('/create', [DistrictLeaderController::class, 'create'])->name('create');
            Route::post('/', [DistrictLeaderController::class, 'store'])->name('store');

            Route::get('/{leader}/edit', [DistrictLeaderController::class, 'edit'])->name('edit');
            Route::put('/{leader}', [DistrictLeaderController::class, 'update'])->name('update');
            Route::delete('/{leader}', [DistrictLeaderController::class, 'destroy'])->name('destroy');

            Route::get('/{leader}', [DistrictLeaderController::class, 'show'])->name('show');
        });

    });

});
//======DISTRICT ADMINS======
Route::get('/admin/district-admins/secretaries/{districtId}', 
    [DistrictAdminController::class, 'getSecretaries']
)->name('admin.district_admins.secretaries');

Route::get('/admin/district-admins/secretaries/{id}', [DistrictAdminController::class, 'getSecretaries']);
Route::get('/admin/district-admins/check/{id}', [DistrictAdminController::class, 'check']);
Route::resource('/admin/district-admins', DistrictAdminController::class);

Route::prefix('admin/district-admins')->name('admin.district_admins.')->group(function () {
    Route::get('/', [DistrictAdminController::class, 'index'])->name('index');
    Route::get('/create', [DistrictAdminController::class, 'create'])->name('create');
    Route::post('/store', [DistrictAdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DistrictAdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DistrictAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [DistrictAdminController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/reset-password', [DistrictAdminController::class, 'reset.password'])->name('reset.password');
});

// ======= ASSEMBLY MANAGEMENT ROUTES ========
Route::prefix('district-admin')
    ->name('district.admin.')
    ->middleware(['district_auth'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::prefix('assemblies')->name('assemblies.')->group(function () {

            Route::get('/', [DistrictAssemblyController::class, 'index'])
                ->name('index');

            Route::get('/create', [DistrictAssemblyController::class, 'create'])
                ->name('create');

            Route::post('/', [DistrictAssemblyController::class, 'store'])
                ->name('store');
                            Route::delete('/{id}', [DistrictAssemblyController::class, 'destroy'])
                ->name('destroy');
        });
});

//=========ASSEMBLY LEADER ROUTES========
Route::prefix('district/assemblies')->group(function () {

    Route::get('{assembly}/leaders', [AssemblyLeaderController::class, 'index'])
        ->name('district.assemblies.leaders.index');

    Route::get('{assembly}/leaders/create', [AssemblyLeaderController::class, 'create'])
        ->name('district.assemblies.leaders.create');

    Route::post('{assembly}/leaders', [AssemblyLeaderController::class, 'store'])
        ->name('district.assemblies.leaders.store');

    Route::get('{assembly}/leaders/{leader}', [AssemblyLeaderController::class, 'show'])
        ->name('district.assemblies.leaders.show');

    Route::get('{assembly}/leaders/{leader}/edit', [AssemblyLeaderController::class, 'edit'])
        ->name('district.assemblies.leaders.edit');

    Route::put('{assembly}/leaders/{leader}', [AssemblyLeaderController::class, 'update'])
        ->name('district.assemblies.leaders.update');

    Route::delete('{assembly}/leaders/{leader}', [AssemblyLeaderController::class, 'destroy'])
        ->name('district.assemblies.leaders.destroy');

});


//=======Assembly members=====
Route::prefix('district/assemblies')->group(function () {

    Route::get('{assembly}/members', [AssemblyMemberController::class, 'index'])
        ->name('district.assemblies.members.index');

    Route::get('{assembly}/members/create', [AssemblyMemberController::class, 'create'])
        ->name('district.assemblies.members.create');

    Route::post('{assembly}/members', [AssemblyMemberController::class, 'store'])
        ->name('district.assemblies.members.store');

    Route::get('{assembly}/members/{member}', [AssemblyMemberController::class, 'show'])
        ->name('district.assemblies.members.show');

    Route::get('{assembly}/members/{member}/edit', [AssemblyMemberController::class, 'edit'])
        ->name('district.assemblies.members.edit');

    Route::put('{assembly}/members/{member}', [AssemblyMemberController::class, 'update'])
        ->name('district.assemblies.members.update');

    Route::delete('{assembly}/members/{member}', [AssemblyMemberController::class, 'destroy'])
        ->name('district.assemblies.members.destroy');

});

Route::prefix('district-admin')->name('district.admin.')->group(function () {

    // ================= PASTORAL TEAM =================
    Route::get('/pastoral-team', [PastoralTeamController::class, 'index'])
        ->name('pastoral.index');

    Route::get('/pastoral-team/create', [PastoralTeamController::class, 'create'])
        ->name('pastoral.create');

    Route::post('/pastoral-team/store', [PastoralTeamController::class, 'store'])
        ->name('pastoral.store');
            // ✅ EDIT
    Route::get('/pastoral-team/{id}/edit', [PastoralTeamController::class, 'edit'])
        ->name('pastoral.edit');

    // ✅ UPDATE
    Route::put('/pastoral-team/{id}/update', [PastoralTeamController::class, 'update'])
        ->name('pastoral.update');

    // ✅ DELETE
    Route::delete('/pastoral-team/{id}/delete', [PastoralTeamController::class, 'destroy'])
        ->name('pastoral.delete');

});

//========ASSEMBLY APPROVALS====
Route::get('/admin/assembly-requests', [AssemblyApprovalController::class, 'index'])
    ->name('admin.assembly.requests');

Route::post('/admin/assembly-requests/{id}/approve', [AssemblyApprovalController::class, 'approve'])
    ->name('admin.assembly.approve');

Route::post('/admin/assembly-requests/{id}/reject', [AssemblyApprovalController::class, 'reject'])
    ->name('admin.assembly.reject');
    Route::get('/district/pastoral/{id}', [\App\Http\Controllers\DistrictAdmin\PastoralTeamController::class, 'show'])
    ->name('district.admin.pastoral.show');

    //====TITHE REPORTS ROUTES=====
    Route::prefix('district/tithes')->name('district.admin.tithes.')->group(function () {

    Route::get('/', [TitheReportController::class, 'index'])->name('index');

    Route::get('/create', [TitheReportController::class, 'create'])->name('create');

    Route::post('/store', [TitheReportController::class, 'store'])->name('store');
       Route::get('/{id}/edit', [TitheReportController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [TitheReportController::class, 'update'])->name('update');
Route::get('/{id}/export', [TitheReportController::class, 'export'])
    ->name('export');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/tithe-reports-review', [App\Http\Controllers\Admin\TitheReportReviewController::class, 'index'])
        ->name('tithe_review.index');

    Route::get('/tithe-reports-review/{id}', [App\Http\Controllers\Admin\TitheReportReviewController::class, 'show'])
        ->name('tithe_review.show');

    Route::post('/tithe-reports-review/{id}/approve', [App\Http\Controllers\Admin\TitheReportReviewController::class, 'approve'])
        ->name('tithe_review.approve');

    Route::post('/tithe-reports-review/{id}/reject', [App\Http\Controllers\Admin\TitheReportReviewController::class, 'reject'])
        ->name('tithe_review.reject');
Route::get('/tithe-reports/export', [App\Http\Controllers\Admin\TitheReportReviewController::class, 'export'])
    ->name('tithe_reports.export');
});

// ======== PASTORAL TRANSFERS ========
Route::prefix('district-admin')->name('district.admin.')->group(function () {

    // =========================
    // LIST
    // =========================
    Route::get('/pastoral-transfers', [PastoralTransferController::class, 'index'])
        ->name('pastoral.transfers.index');

    // =========================
    // CREATE FORM
    // =========================
    Route::get('/pastoral-transfers/create', [PastoralTransferController::class, 'create'])
        ->name('pastoral.transfers.create');

    // =========================
    // STORE
    // =========================
    Route::post('/pastoral-transfers', [PastoralTransferController::class, 'store'])
        ->name('pastoral.transfers.store');

    // =========================
    // EDIT
    // =========================
    Route::get('/pastoral-transfers/{id}/edit', [PastoralTransferController::class, 'edit'])
        ->name('pastoral.transfers.edit');

    // =========================
    // UPDATE (IMPORTANT - WAS MISSING)
    // =========================
    Route::put('/pastoral-transfers/{id}', [PastoralTransferController::class, 'update'])
        ->name('pastoral.transfers.update');

    // =========================
    // DELETE
    // =========================
    Route::delete('/pastoral-transfers/{id}', [PastoralTransferController::class, 'destroy'])
        ->name('pastoral.transfers.destroy');

    // =========================
    // APPROVE
    // =========================
    Route::post('/pastoral-transfers/{id}/approve', [PastoralTransferController::class, 'approve'])
        ->name('pastoral.transfers.approve');

    // =========================
    // REJECT
    // =========================
    Route::post('/pastoral-transfers/{id}/reject', [PastoralTransferController::class, 'reject'])
        ->name('pastoral.transfers.reject');

    // =========================
    // AJAX: GET ASSEMBLIES BY DISTRICT
    // =========================
    Route::get('/get-assemblies/{district_id}', function ($district_id) {
        return response()->json(
            \App\Models\Assembly::where('district_id', $district_id)->get()
        );
    })->name('assemblies.by.district');

});

// =========================
// NOTIFICATIONS
// =========================
Route::prefix('district-admin')->name('district.admin.')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read.all');
        Route::get('/pastoral-transfers/incoming', [PastoralTransferController::class, 'incoming'])
    ->name('pastoral.transfers.incoming');
});

//====== ADMIN TRANSFER APPROVALS ======
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    // LIST ALL PENDING HQ APPROVALS
    Route::get('/transfers', [TransferApprovalController::class, 'index'])
        ->name('transfers');

    // APPROVE TRANSFER (HQ)
    Route::post('/transfers/{id}/approve', [TransferApprovalController::class, 'approve'])
        ->name('transfers.approve');

    // REJECT TRANSFER (HQ) ✅ FIXED
    Route::post('/transfers/{id}/reject', [TransferApprovalController::class, 'reject'])
        ->name('transfers.reject');

});


// ======== DISTRICT PASTORAL TEAM (ADMIN SIDE) ========
Route::prefix('admin')->name('admin.')->group(function () {

    // LIST pastors in a district
    Route::get('districts/{district}/pastoral-teams',
        [App\Http\Controllers\Admin\PastoralTeamController::class, 'index']
    )->name('districts.pastoral-teams.index');

    // SHOW pastor profile (IMPORTANT FIX: name matches view usage)
    Route::get('districts/pastoral-teams/{id}',
        [App\Http\Controllers\Admin\PastoralTeamController::class, 'show']
    )->name('districts.pastoral-teams.show');
    Route::get('districts/{district}/pastoral-teams/export', 
    [App\Http\Controllers\Admin\PastoralTeamController::class, 'exportPdf']
)->name('districts.pastoral-teams.export');
});

//=========DOWNLOAD ROUTES====
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/downloads', [DownloadController::class, 'index'])
        ->name('admin.downloads.index');

    Route::get('/downloads/create', [DownloadController::class, 'create'])
        ->name('admin.downloads.create');

    Route::post('/downloads', [DownloadController::class, 'store'])
        ->name('admin.downloads.store');

    // VIEW
    Route::get('/downloads/{id}', [DownloadController::class, 'show'])
        ->name('admin.downloads.show');

    // EDIT
    Route::get('/downloads/{id}/edit', [DownloadController::class, 'edit'])
        ->name('admin.downloads.edit');

    Route::put('/downloads/{id}', [DownloadController::class, 'update'])
        ->name('admin.downloads.update');

    // DELETE
    Route::delete('/downloads/{id}', [DownloadController::class, 'destroy'])
        ->name('admin.downloads.destroy');
});

//------DISTRICT ADMIN DOWNLOADS------
Route::prefix('district/admin')->group(function () {

    Route::get('/downloads', [\App\Http\Controllers\Admin\DownloadController::class, 'districtIndex'])
        ->name('district.admin.downloads.index');

});

//=====export reports routes=====
Route::prefix('admin')->group(function () {

    Route::get('/exports', [OverseerReportController::class, 'index'])
        ->name('admin.exports.index');

    Route::get('/export/overseer-reimbursement', [OverseerReportController::class, 'form'])
        ->name('admin.export.overseer.form');

    Route::post('/export/overseer-reimbursement', [OverseerReportController::class, 'export'])
        ->name('admin.export.overseer.generate');

});

//-------NATIONAL OFFICE SHARE-------
Route::get('/admin/export/national-office-share', 
    [NationalOfficeShareController::class, 'form']
)->name('admin.export.national.form');

Route::post('/admin/export/national-office-share', 
    [NationalOfficeShareController::class, 'export']
)->name('admin.export.national.generate');

//=====DISTRICT SHARE EXPORT=======
Route::get('/admin/district-summary', [DistrictSummaryController::class, 'form'])
    ->name('admin.export.district_summary.form');

Route::post('/admin/district-summary/generate', [DistrictSummaryController::class, 'export'])
    ->name('admin.export.district_summary.generate');


    //======Download transfer letter=======
Route::get(
    '/district-admin/pastoral-transfers/{id}/download-letter',
    [PastoralTransferLetterController::class, 'download']
)->name('district.admin.pastoral.transfers.download');

//=====live stats=======
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/dashboard-stats', [DashboardStatsController::class, 'index'])
        ->name('dashboard.stats');

});

//=====national pastor approval=======
Route::prefix('admin')->name('admin.')->group(function () {

    // LIST
    Route::get('/national-pastoral-approvals',
        [NationalPastoralApprovalController::class, 'index']
    )->name('national.pastoral.approvals.index');

    // VIEW (THIS IS WHAT YOU ARE MISSING)
    Route::get('/national-pastoral-approvals/view/{id}',
        [NationalPastoralApprovalController::class, 'view']
    )->name('national.pastoral.approvals.view');

    // APPROVE
    Route::post('/national-pastoral-approvals/approve/{id}',
        [NationalPastoralApprovalController::class, 'approve']
    )->name('national.pastoral.approvals.approve');

    // REJECT
    Route::post('/national-pastoral-approvals/reject/{id}',
        [NationalPastoralApprovalController::class, 'reject']
    )->name('national.pastoral.approvals.reject');

});