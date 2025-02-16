<?php

namespace App\Listeners;

use Native\Laravel\Events\Settings\SettingChanged;
use App\Facades\LolClient;

class HandleSettingChanged
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SettingChanged $event): void
    {
        $this->updateSettingsWithLockFile($event);
    }

    public function updateSettingsWithLockFile(SettingChanged $event)
    {
        $key = $event->key;
        $value = $event->value;

        if ($key !== "lockfile") {
            return;
        }

        LolClient::updateSettingsWithLockFile($value);
    }
}
