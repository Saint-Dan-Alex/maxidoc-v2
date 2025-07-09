<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\DocumentCreated;
use App\Listeners\SendDocumentCreatedNotification;
use App\Events\CourrierCreated;
use App\Listeners\SendCourrierCreatedNotification;
use App\Events\TacheCreated;
use App\Listeners\SendTacheCreatedNotification;
use App\Events\CourrierPartage;
use App\Listeners\SendCourrierPartageNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        DocumentCreated::class => [
            SendDocumentCreatedNotification::class
        ],

        CourrierCreated::class => [
            SendCourrierCreatedNotification::class
        ],

        TacheCreated::class => [
            SendTacheCreatedNotification::class
        ],

        CourrierPartage::class => [
            SendCourrierPartageNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
