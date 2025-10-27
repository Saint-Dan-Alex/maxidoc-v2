<?php

namespace App\Listeners;

use App\Notifications\TwoFactorEmailCode;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;

class SendTwoFactorEmailCode
{
    /**
     * Handle the event.
     */
    public function handle(TwoFactorAuthenticationChallenged $event): void
    {
        $user = $event->user;
        
        // Générer un code aléatoire à 6 chiffres
        $code = (string) random_int(100000, 999999);
        
        // Hasher et stocker le code
        $user->forceFill([
            'two_factor_email_code' => Hash::make($code),
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();
        
        // Envoyer la notification
        $user->notify(new TwoFactorEmailCode($code));
    }
}
