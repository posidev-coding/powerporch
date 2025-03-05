<?php

namespace App\Jobs\Feeds;


use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncTeams implements ShouldQueue
{
    use Queueable;

    const LIMIT = 1000;

    public function handle(): void
    {

        $teams = Http::get(config('espn.teams') . '?limit=' . self::LIMIT)->json()['items'];

        $jobs = [];

        foreach ($teams as $team) {
            array_push($jobs, new SyncTeam($team['$ref']));
        }

        $batch = Bus::batch($jobs)
            ->name('Teams')
            ->allowFailures()
            ->dispatch();
    }
}
