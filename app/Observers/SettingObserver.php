<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Native\Laravel\Facades\Notification;
use App\Events\LolConnectionStateChanged;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        $oldStatus = $setting->getOriginal('LolConnectionState');
        $newStatus = $setting->LolConnectionState;

        Log::info('SettingObserver: updated');

        if($setting->key == "LolConnectionState"){
            if($oldStatus !== 'connected' && $newStatus === 'connected'){
                Log::info('League of Legends client connected');

                LolConnectionStateChanged::dispatch($newStatus);
            }
            if($oldStatus !== 'disconnected' && $newStatus === 'disconnected'){
                Log::info('League of Legends client disconnected');

                LolConnectionStateChanged::dispatch($newStatus);
            }
        }
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     */
    public function restored(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     */
    public function forceDeleted(Setting $setting): void
    {
        //
    }
}
