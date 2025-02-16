<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LolClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lolclient';
    }
}
