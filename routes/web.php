<?php

use App\Livewire\Conferences\ShowConference as Conference;
use App\Livewire\Conferences\ViewConferences as Standings;
use App\Livewire\Feeds\Feeds;
use App\Livewire\Games\ShowGame as Game;
use App\Livewire\Games\ViewGames as Scores;
use App\Livewire\Rankings\ViewRankings as Rankings;
use App\Livewire\Teams\ShowTeam as Team;
use App\Livewire\Teams\ViewTeams as Teams;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'home')->name('home');

Route::get('/scores', Scores::class)->name('scores');
Route::get('/scores/{game}', Game::class)->name('game');

Route::get('/teams', Teams::class)->name('teams');
Route::get('/teams/{team}', Team::class)->name('team');

Route::get('/standings', Standings::class)->name('standings');
Route::get('/standings/{conference}', Conference::class)->name('conference');

Route::get('/rankings', Rankings::class)->name('rankings');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Feeds
    Route::get('/feeds', Feeds::class)->name('feeds');
});

require __DIR__.'/auth.php';
