<?php

namespace App\Console\Commands;

use App\Facades\LolClient;
use Illuminate\Console\Command;
use App\Events\PlayerStatusChanged;
use Illuminate\Support\Facades\Log;

class CheckPlayerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lol:check-player-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of the connected League of Legends client.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(!LolClient::isConnected()){
            return;
        }

        $this->info("checking player status");
        $playerStatus = LolClient::updatePlayerStatus();
        $this->info("playerStatus: $playerStatus");

        PlayerStatusChanged::dispatch($playerStatus);
        
        if($playerStatus === "ReadyCheck"){
            LolClient::readyCheckAccept();
        }
    }

    public function info($message, $verbosity = null)
    {
        Log::info($message);
        parent::info($message, $verbosity);
    }
}
