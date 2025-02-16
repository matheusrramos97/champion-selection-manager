<?php

namespace App\Models;

use App\Observers\SettingObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SettingObserver::class])]
class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    protected $connection = 'sqlite';
}
