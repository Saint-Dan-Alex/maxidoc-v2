<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\Pointage;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\TwoFactorAuthService;
use App\Http\Controllers\AuthController;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->where('statut_id', 1)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // Vérifier si la 2FA est activée
                $authController = app(AuthController::class);
                
                if ($authController->isTwoFactorEnabled($user)) {
                    // Générer et envoyer le code 2FA
                    $authController->sendTwoFactorCode($user);
                    
                    // Stocker en session
                    session([
                        '2fa_email' => $user->email,
                        '2fa_id' => $user->id,
                        '2fa_remember' => $request->filled('remember'),
                    ]);
                    
                    // Créer une exception de validation pour rediriger
                    $validator = validator([], []);
                    throw \Illuminate\Validation\ValidationException::withMessages([])
                        ->redirectTo(route('auth.two-factor.challenge'));
                }
                
                return $user;
            }

            return null;
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
