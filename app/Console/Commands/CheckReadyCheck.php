<?php

namespace App\Console\Commands;

use App\Facades\LolClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckReadyCheck extends Command
{
    protected $signature = 'lol:check-ready-check';

    protected $description = 'Check matchmaking status.';

    public function handle()
    {
        if(!LolClient::isConnected()){
            return;
        }

        $playerStatus = LolClient::getPlayerStatus();

        if($playerStatus !== "Matchmaking"){
            return;
        }

        $this->info("checking ready check");
        $readyCheck = LolClient::updateReadyCheck();
        $this->info("readyCheck: $readyCheck");

        if($readyCheck){
            LolClient::readyCheckAccept();
        }
    }

    public function info($message, $verbosity = null)
    {
        Log::info($message);
        parent::info($message, $verbosity);
    }
}
