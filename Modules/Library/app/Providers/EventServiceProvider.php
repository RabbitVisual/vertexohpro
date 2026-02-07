<?php

namespace Modules\Library\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Modules\Library\Listeners\CheckForUpdatesOnLogin;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            CheckForUpdatesOnLogin::class,
        ],
    ];
}
