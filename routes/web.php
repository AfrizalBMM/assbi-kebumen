<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Public\{
    HomeController,
    ClubPublicController,
    TournamentPublicController,
    PlayerPublicController,
    PostController,
    StatsController
};

Route::get('/', HomeController::class)->name('home');

Route::get('/clubs', [ClubPublicController::class,'index'])->name('clubs.index');
Route::get('/clubs/{slug}', [ClubPublicController::class,'show'])->name('clubs.show');

Route::get('/players/{player}', [PlayerPublicController::class,'show'])->name('players.show');

Route::get('/tournaments', [TournamentPublicController::class,'index'])->name('tournaments.index');
Route::get('/tournaments/{slug}', [TournamentPublicController::class,'show'])->name('tournaments.show');

Route::get('/tournaments/{tournament}/top-scorers', [StatsController::class,'topScorers'])->name('tournaments.topScorers');
Route::get('/tournaments/{tournament}/fair-play', [StatsController::class,'fairPlay'])->name('tournaments.fairPlay');

/* News & Content */
Route::get('/news', [PostController::class,'index'])->defaults('type','news')->name('news.index');
Route::get('/articles', [PostController::class,'index'])->defaults('type','article')->name('articles.index');
Route::get('/announcements', [PostController::class,'index'])->defaults('type','announcement')->name('announcements.index');

Route::get('/news/{slug}', [PostController::class,'show'])->defaults('type','news')->name('news.show');
Route::get('/articles/{slug}', [PostController::class,'show'])->defaults('type','article')->name('articles.show');
Route::get('/announcements/{slug}', [PostController::class,'show'])->defaults('type','announcement')->name('announcements.show');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| REGISTRATION (CLUB & EO)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\RegisterClubController;
use App\Http\Controllers\Auth\RegisterEOController;

Route::get('/register/club', [RegisterClubController::class,'create'])->name('register.club');
Route::post('/register/club', [RegisterClubController::class,'store'])->name('register.club.store');

Route::get('/register/eo', [RegisterEOController::class,'create'])->name('register.eo');
Route::post('/register/eo', [RegisterEOController::class,'store'])->name('register.eo.store');

Route::get('/register/success', function () {
    return view('auth.register-success');
})->name('register.success');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminClubController,
    AdminEventOrganizerController,
    AdminTournamentController,
    AdminUserController,
    AdminPlayerController,
    AdminPostController,
    AdminActivityController,
    AdminBannerController
};

Route::middleware(['auth','status','role:admin'])
->prefix('admin')
->name('admin.')
->group(function(){

    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');

    // Clubs
    Route::resource('clubs',AdminClubController::class);
    Route::post('clubs/{club}/suspend',[AdminClubController::class,'suspend'])->name('clubs.suspend');
    Route::post('clubs/{club}/activate',[AdminClubController::class,'activate'])->name('clubs.activate');

    // Event Organizers
    Route::resource('event-organizers',AdminEventOrganizerController::class);
    Route::post('event-organizers/{eo}/suspend',[AdminEventOrganizerController::class,'suspend'])->name('event-organizers.suspend');
    Route::post('event-organizers/{eo}/activate',[AdminEventOrganizerController::class,'activate'])->name('event-organizers.activate');

    // Tournaments
    Route::get('tournaments',[AdminTournamentController::class,'index'])->name('tournaments.index');
    Route::get('tournaments/{tournament}',[AdminTournamentController::class,'show'])->name('tournaments.show');
    Route::post('tournaments/{tournament}/suspend',[AdminTournamentController::class,'suspend'])->name('tournaments.suspend');
    Route::post('tournaments/{tournament}/activate',[AdminTournamentController::class,'activate'])->name('tournaments.activate');

    // Users
    Route::resource('users',AdminUserController::class);
    Route::post('users/{user}/suspend',[AdminUserController::class,'suspend'])->name('users.suspend');
    Route::post('users/{user}/activate',[AdminUserController::class,'activate'])->name('users.activate');
    Route::post('users/{user}/reset-password',[AdminUserController::class,'resetPassword'])->name('users.resetPassword');

    // Players
    Route::get('players',[AdminPlayerController::class,'index'])->name('players.index');
    Route::get('players/{player}',[AdminPlayerController::class,'show'])->name('players.show');
    Route::post('players/{player}/suspend',[AdminPlayerController::class,'suspend'])->name('players.suspend');
    Route::post('players/{player}/activate',[AdminPlayerController::class,'activate'])->name('players.activate');

    // Content
    Route::resource('posts', AdminPostController::class);
    Route::post('posts/{post}/publish',[AdminPostController::class,'publish'])->name('posts.publish');
    Route::post('posts/{post}/unpublish',[AdminPostController::class,'unpublish'])->name('posts.unpublish');

    // Activity Logs
    Route::get('activity-logs', [AdminActivityController::class,'index'])->name('activity.index');

    // Banners (monitor only)
    Route::get('banners',[AdminBannerController::class,'index'])->name('banners.index');
    Route::post('banners/{banner}/approve',[AdminBannerController::class,'approve'])->name('banners.approve');
    Route::post('banners/{banner}/disable',[AdminBannerController::class,'disable'])->name('banners.disable');
});


/*
|--------------------------------------------------------------------------
| CLUB
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Club\{
    ClubProfileController,
    ClubTournamentController,
    PlayerController
};

Route::middleware(['auth','status','role:club'])
->prefix('club')
->name('club.')
->group(function(){

    Route::get('/dashboard', fn()=>view('club.dashboard'))->name('dashboard');

    Route::get('/profile',[ClubProfileController::class,'edit'])->name('profile');
    Route::put('/profile',[ClubProfileController::class,'update'])->name('profile.update');

    Route::get('tournaments',[ClubTournamentController::class,'index'])->name('tournaments.index');
    Route::post('tournaments/{tournament}/register',[ClubTournamentController::class,'register'])->name('tournaments.register');

    Route::resource('players',PlayerController::class);
});


/*
|--------------------------------------------------------------------------
| EO
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\EO\{
    TournamentController,
    ParticipantController,
    GroupController,
    MatchGeneratorController,
    MatchController,
    StandingController,
    KnockoutController,
    MatchListController,
    KnockoutViewController,
    BannerController
};

Route::middleware(['auth','status','role:eo'])
->prefix('eo')
->name('eo.')
->group(function(){

    Route::get('/dashboard', fn()=>view('eo.dashboard'))->name('dashboard');

    Route::resource('tournaments',TournamentController::class);
    Route::post('tournaments/{tournament}/publish',[TournamentController::class,'publish'])->name('tournaments.publish');
    Route::post('tournaments/{tournament}/close',[TournamentController::class,'close'])->name('tournaments.close');

    Route::get('tournaments/{tournament}/participants',[ParticipantController::class,'index'])->name('tournaments.participants');
    Route::post('registrations/{registration}/approve',[ParticipantController::class,'approve'])->name('registrations.approve');
    Route::post('registrations/{registration}/reject',[ParticipantController::class,'reject'])->name('registrations.reject');

    Route::get('tournaments/{tournament}/groups',[GroupController::class,'index'])->name('tournaments.groups');
    Route::post('tournaments/{tournament}/groups/auto',[GroupController::class,'autoGenerate'])->name('groups.auto');
    Route::post('groups/{group}/add-club',[GroupController::class,'addClub'])->name('groups.addClub');
    Route::post('groups/{group}/remove-club',[GroupController::class,'removeClub'])->name('groups.removeClub');

    Route::post('tournaments/{tournament}/generate-matches',[MatchGeneratorController::class,'generateGroupMatches'])->name('tournaments.generateMatches');

    Route::get('matches/{match}/edit',[MatchController::class,'edit'])->name('matches.edit');
    Route::put('matches/{match}',[MatchController::class,'update'])->name('matches.update');

    Route::get('tournaments/{tournament}/standings',[StandingController::class,'index'])->name('tournaments.standings');

    Route::post('tournaments/{tournament}/generate-knockout',[KnockoutController::class,'generate'])->name('tournaments.generateKnockout');
    Route::post('tournaments/{tournament}/generate-next-stage',[KnockoutController::class,'generateNext'])->name('tournaments.generateNextStage');

    Route::get('tournaments/{tournament}/matches',[MatchListController::class,'index'])->name('tournaments.matches');
    Route::get('tournaments/{tournament}/knockout',[KnockoutViewController::class,'index'])->name('tournaments.knockout');

    // Tournament Banners
    Route::get('tournaments/{tournament}/banners',[BannerController::class,'index'])->name('tournaments.banners');
    Route::post('tournaments/{tournament}/banners',[BannerController::class,'store'])->name('tournaments.banners.store');
    Route::post('banners/{banner}/toggle',[BannerController::class,'toggle'])->name('banners.toggle');
});
