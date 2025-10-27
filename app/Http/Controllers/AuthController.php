<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $twoFactorService;

    public function __construct(TwoFactorAuthService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Vérifie si le 2FA est activé pour un utilisateur
     * 
     * Personnalisez cette méthode selon vos besoins:
     * - return true; // 2FA obligatoire pour tous
     * - return $user->two_factor_enabled; // Basé sur une colonne
     * - return $user->hasRole(['admin', 'manager']); // Basé sur le rôle
     */
    public function isTwoFactorEnabled(User $user): bool
    {
        // 2FA activée pour tous les utilisateurs
        return true;
        
        // Décommentez pour activer selon une colonne en base:
        // return $user->two_factor_enabled ?? false;
        
        // Décommentez pour activer selon le rôle:
        // return $user->hasRole(['admin', 'manager']);
    }

    /**
     * Génère et envoie un code 2FA
     */
    public function sendTwoFactorCode(User $user): void
    {
        $code = $this->twoFactorService->generateAndStoreCode($user);
        $this->twoFactorService->sendCodeByEmail($user, $code);
        
        Log::info('Code 2FA envoyé', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /**
     * Affiche la page de saisie du code 2FA
     */
    public function showTwoFactorChallenge()
    {
        if (!session()->has('2fa_email')) {
            return redirect()->route('login')->withErrors(['email' => 'Session expirée. Veuillez vous reconnecter.']);
        }

        return view('auth.two-factor-email-challenge');
    }

    /**
     * Vérifie le code 2FA saisi par l'utilisateur
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $code = $request->code;

        // Vérifier que l'email correspond à la session
        if (session('2fa_email') !== $email) {
            return back()->withErrors(['code' => 'Session invalide. Veuillez vous reconnecter.']);
        }

        // Vérifier le code
        if (!$this->twoFactorService->verifyCode($code, $email)) {
            Log::warning('Tentative de 2FA échouée', [
                'email' => $email,
                'ip' => $request->ip(),
            ]);
            
            return back()->withErrors(['code' => 'Le code est invalide ou a expiré.']);
        }

        // Récupérer l'utilisateur et le connecter
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors(['code' => 'Utilisateur non trouvé.']);
        }

        Auth::login($user);
        
        // Nettoyer la session
        session()->forget(['2fa_email', '2fa_id']);
        
        Log::info('Connexion 2FA réussie', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return redirect()->intended(route('regidoc.home'));
    }

    /**
     * Renvoie un nouveau code 2FA
     */
    public function resendTwoFactorCode()
    {
        if (!session()->has('2fa_email')) {
            return redirect()->route('login')->withErrors(['email' => 'Session expirée. Veuillez vous reconnecter.']);
        }

        $email = session('2fa_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé.']);
        }

        $this->sendTwoFactorCode($user);

        return back()->with('status', 'Un nouveau code a été envoyé à votre adresse email.');
    }
}
