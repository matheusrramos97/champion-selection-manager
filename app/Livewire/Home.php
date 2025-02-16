<?php

namespace App\Livewire;

use Livewire\Component;
use App\Facades\LolClient;
use Livewire\Attributes\On;
use Native\Laravel\Facades\Window;
use App\Events\PlayerStatusChanged;
use App\Events\LolConnectionStateChanged;

class Home extends Component
{
    public $leagueConnected;
    public $summonerName;
    public $summonerIconUrl;
    public $playerStatus;
    
    public function mount()
    {
        $this->setup();
    }

    public function setup()
    {
        $this->leagueConnected = LolClient::isConnected();

        if ($this->leagueConnected) {
            if($summoner = LolClient::getSummoner()){
                $this->summonerName = "{$summoner['gameName']} #{$summoner['tagLine']}";
                $this->summonerIconUrl = LolClient::getIconUrl(profileIconId: $summoner['profileIconId']);
            }

            $this->updatePlayerStatus();
        }
    }

    #[On('native:'.LolConnectionStateChanged::class)]
    public function updateLeagueConnected(){
        $this->leagueConnected = LolClient::isConnected();

        if($this->leagueConnected){
            if($summoner = LolClient::getSummoner()){
                $this->summonerName = "{$summoner['gameName']} #{$summoner['tagLine']}";
                $this->summonerIconUrl = LolClient::getIconUrl(profileIconId: $summoner['profileIconId']);
            }
        }
    }

    #[On('native:'.PlayerStatusChanged::class)]
    public function updatePlayerStatus(){
        $this->playerStatus = LolClient::getPlayerStatus();
    }
    public function quit($window)
    {
        Window::close($window);
    }
    public function reconnect()
    {
        try {
            LolClient::bootSettings();
            $this->setup();
        } catch (\Throwable $th) {
            return;
        }
    }
    public function open($window)
    {
        Window::open($window)->url(route($window));
        Window::get($window)
            ->hideDevTools()
            ->rememberState()
            ->title(env("APP_NAME"))
            ->hideMenu();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
