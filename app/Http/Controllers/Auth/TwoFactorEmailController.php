<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TwoFactorEmailCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TwoFactorEmailController extends Controller
{
    /**
     * Envoie un code 2FA par email
     */
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé.']);
        }
        
        // Générer un code aléatoire à 6 chiffres
        $code = (string) random_int(100000, 999999);
        
        // Hasher et stocker le code
        $user->forceFill([
            'two_factor_email_code' => Hash::make($code),
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();
        
        // Envoyer la notification
        $user->notify(new TwoFactorEmailCode($code));
        
        return back()->with('status', 'Un code de vérification a été envoyé à votre adresse email.');
    }
    
    /**
     * Vérifie le code email
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé.']);
        }
        
        // Vérifier l'expiration
        if ($user->two_factor_expires_at && $user->two_factor_expires_at->isPast()) {
            return back()->withErrors(['code' => 'Le code a expiré. Veuillez demander un nouveau code.']);
        }
        
        // Vérifier le code
        if (!$user->two_factor_email_code || !Hash::check($request->code, $user->two_factor_email_code)) {
            return back()->withErrors(['code' => 'Le code est invalide.']);
        }
        
        // Marquer comme confirmé
        $user->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_email_code' => null,
            'two_factor_expires_at' => null,
        ])->save();
        
        return redirect()->intended(route('regidoc.home'))->with('status', 'Authentification réussie !');
    }
}
