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
use App\Events\TacheConsulted;
use App\Listeners\SendTacheConsultedNotification;
use App\Events\CourrierPartage;
use App\Listeners\SendCourrierPartageNotification;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use App\Listeners\SendTwoFactorEmailCode;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\MarkAuthenticationSuccess;
use App\Listeners\MarkAuthenticationLogout;

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
        
        TacheConsulted::class => [
            SendTacheConsultedNotification::class
        ],

        TwoFactorAuthenticationChallenged::class => [
            SendTwoFactorEmailCode::class
        ],

        Login::class => [
            MarkAuthenticationSuccess::class,
        ],

        Logout::class => [
            MarkAuthenticationLogout::class,
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
