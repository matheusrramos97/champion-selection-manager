<?php

namespace App\Providers;

use Native\Laravel\Facades\Menu;
use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Contracts\ProvidesPhpIni;
use App\Facades\LolClient;
use App\Helpers\SettingsHelper;
use Native\Laravel\Facades\OperatingSystem;
use Native\Laravel\Facades\Notification;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        MenuBar::create()->showDockIcon();

        try {
            LolClient::bootSettings();
        } catch (\Throwable $th) {
            Notification::title(env("APP_NAME"))->message($th->getMessage())->show();
        }
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
            'openssl'
        ];
    }
}
