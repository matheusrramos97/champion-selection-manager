<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Helpers\SettingsHelper;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Native\Laravel\Facades\Notification;
use Illuminate\Support\Facades\Log;

class LolClient
{
    protected string $baseUrl;
    protected string $authHeader;

    public function __construct()
    {
        $this->loadSettings();
    }

    public function isConnected()
    {
        return SettingsHelper::get('LolConnectionState', "disconnected") == "connected";
    }

    public function updateSettingsWithLockFile(string $lockFilePath)
    {
        if (!file_exists($lockFilePath)) {
            $this->deleteSettings();
        }

        $lockFileContent = file_get_contents($lockFilePath);
        $lockfileData = explode(':', $lockFileContent);

        if (count($lockfileData) < 5) {
            $this->deleteSettings();
        }

        $this->storeSettings(lockFilePath: $lockFilePath, lockfileData: $lockfileData);
        $this->loadSettings();
    }

    public function deleteSettings()
    {
        SettingsHelper::forget('lockfile_name');
        SettingsHelper::forget('lockfile_pid');
        SettingsHelper::forget('lockfile_port');
        SettingsHelper::forget('lockfile_auth_token');
        SettingsHelper::forget('lockfile_protocol');
        SettingsHelper::forget('base_url');
        SettingsHelper::set('LolConnectionState', "disconnected");
    }

    public function storeSettings(string $lockFilePath, array $lockfileData)
    {
        [$name, $pid, $port, $authToken, $protocol] = $lockfileData;

        $baseUrl = "{$protocol}://127.0.0.1:{$port}";
        SettingsHelper::set('base_url', $baseUrl);
        SettingsHelper::set('lockfile_path', $lockFilePath);
        SettingsHelper::set('lockfile_name', $name);
        SettingsHelper::set('lockfile_pid', $pid);
        SettingsHelper::set('lockfile_port', $port);
        SettingsHelper::set('lockfile_auth_token', $authToken);
        SettingsHelper::set('lockfile_protocol', $protocol);
        SettingsHelper::set('LolConnectionState', "connected");
    }

    private function loadSettings()
    {
        $port = SettingsHelper::get('lockfile_port');
        $authToken = SettingsHelper::get('lockfile_auth_token');
        $protocol = SettingsHelper::get('lockfile_protocol', 'https');

        $this->baseUrl = "{$protocol}://127.0.0.1:{$port}";
        $this->authHeader = 'Basic ' . base64_encode("riot:$authToken");
    }

    private function request(string $endpoint, string $method = 'get', array $body = [], int $attempt = 1)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authHeader,
                'Content-Type' => 'application/json',
            ])->withoutVerifying()
                ->$method("{$this->baseUrl}{$endpoint}", $body);

            $response->throw();

            return $response->json();
        } catch (ConnectionException | RequestException $e) {
            if ($attempt === 1) {
                $this->bootSettings();
                return $this->request($endpoint, $method, $body, attempt: 2);
            }

            return false;
        }
    }

    public function updatePlayerStatus()
    {
        if ($this->isConnected()) {
            $playerStatusData = $this->request('/lol-gameflow/v1/session');
            $playerStatus = $playerStatusData["phase"] ?? "Connected";
        } else {
            $playerStatus = "Disconnected";
        }

        SettingsHelper::set('PlayerStatus', $playerStatus);
        return $playerStatus;
    }

    public function getPlayerStatus()
    {
        if ($this->isConnected()) {
            $playerStatus = SettingsHelper::get('PlayerStatus', "Connected");
        }else{
            $playerStatus = "Disconnected";
        }

        return $playerStatus;
    }

    public function updateReadyCheck(){
        if ($this->isConnected()) {
            $readyCheckData = $this->request('/lol-matchmaking/v1/ready-check');
            $readyCheck = isset($readyCheckData["state"]) ? $readyCheckData["state"] === 'InProgress' : false;
        } else {
            $readyCheck = false;
        }
        
        SettingsHelper::set('ReadyCheck', $readyCheck);

        return $readyCheck;
    }

    public function readyCheckAccept(){
        return $this->request('/lol-matchmaking/v1/ready-check/accept', 'post');
    }

    public function getReadyCheck(){
        if ($this->isConnected()) {
            $readyCheck = SettingsHelper::get('ReadyCheck', "Connected");
        }else{
            $readyCheck = false;
        }

        return $readyCheck;
    }

    public function getSummoner()
    {
        return $this->request('/lol-summoner/v1/current-summoner');
    }

    public function setSummonerIcon(int $profileIconId)
    {
        return $this->request('/lol-summoner/v1/current-summoner/icon', 'put', [
            'profileIconId' => $profileIconId
        ]);
    }

    public function getSummonerProfile()
    {
        return $this->request('/lol-summoner/v1/summoner-profile');
    }

    public function getIconUrl($profileIconId)
    {
        $currentVersion = $this->getCurrentVersion();

        return "https://ddragon.leagueoflegends.com/cdn/{$currentVersion}/img/profileicon/{$profileIconId}.png";
    }

    public function getCurrentVersion()
    {
        $lastRequestDate = SettingsHelper::get('last_version_check');
        $currentVersion = SettingsHelper::get('current_version');

        if (!$lastRequestDate || strtotime($lastRequestDate) < strtotime('-1 day')) {
            try {
                $response = Http::get("https://ddragon.leagueoflegends.com/api/versions.json");

                if ($response->successful()) {
                    $lolVersions = $response->json();

                    if (!empty($lolVersions) && isset($lolVersions[0])) {
                        $currentVersion = $lolVersions[0];
                        SettingsHelper::set('current_version', $currentVersion);
                        SettingsHelper::set('last_version_check', now());
                        return $currentVersion;
                    }
                    throw new \Exception("Version not found in API response.");
                }
                throw new \Exception("Error accessing the API. Status code: " . $response->status());
            } catch (\Exception $e) {
                return '15.3.1';
            }
        }

        return $currentVersion ?: '15.3.1';
    }

    public function getMatchHistory()
    {
        return $this->request('/lol-match-history/v1/products/lol/current-summoner/matches');
    }

    public function getChampSelect()
    {
        return $this->request('/lol-champ-select/v1/session');
    }

    public function getLockFilePath()
    {
        $lockFilePath = SettingsHelper::get('lockfile');

        if (file_exists($lockFilePath)) {
            return $lockFilePath;
        }

        $path = match (PHP_OS_FAMILY) {
            "Windows" => 'C:\Riot Games\League of Legends\lockfile',
            "Darwin" => '/Applications/League of Legends.app/Contents/LoL/lockfile',
            default => null
        };

        return $path;
    }

    public function bootSettings()
    {
        try {
            $this->connect();
        } catch (\Exception $e) {
            Notification::title(env("APP_NAME"))->message($e->getMessage())->show();
        }
    }

    public function connect()
    {
        $lockFilePath = LolClient::getLockFilePath();

        if ($lockFilePath) {
            LolClient::updateSettingsWithLockFile($lockFilePath);
        }
    }
}
