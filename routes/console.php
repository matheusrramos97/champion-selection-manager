<?php

use App\Facades\LolClient;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('lol:check-connection')->everyTenSeconds();

Schedule::command('lol:check-player-status')->everyFiveSeconds();

Schedule::command('lol:check-ready-check')->everyTwoSeconds();