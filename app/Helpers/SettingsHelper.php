<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    public static function get($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

    public static function set($key, $value)
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    public static function forget($key)
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            $setting->delete();
            return true;
        }

        return false;
    }
}