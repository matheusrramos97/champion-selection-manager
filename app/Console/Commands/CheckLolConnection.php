<?php

namespace App\Console\Commands;

use App\Facades\LolClient;
use App\Helpers\SettingsHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Events\LolConnectionStateChanged;

class CheckLolConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lol:check-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if the League of Legends client is connected.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("checking connection to league of legends");
        $lolConnectionState = LolClient::isConnected();
        $lolConnectionStateName = $lolConnectionState ? "connected" : "disconnected";
        $this->info("lolConnectionState: {$lolConnectionStateName}");

        LolConnectionStateChanged::dispatch($lolConnectionState);

        if ($lolConnectionState) {
            return;
        }

        LolClient::connect();
    }

    public function info($message, $verbosity = null)
    {
        Log::info($message);
        parent::info($message, $verbosity);
    }
}
