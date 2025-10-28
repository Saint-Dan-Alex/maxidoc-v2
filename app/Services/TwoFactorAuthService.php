<?php

namespace App\Services;

use App\Models\User;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TwoFactorAuthService
{
    /**
     * Génère un code aléatoire à 6 chiffres
     */
    protected function generateCode(): string
    {
        return str_pad((string) mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Génère et stocke le code pour un utilisateur
     */
    public function generateAndStoreCode(User $user): string
    {
        $code = $this->generateCode();
        
        // Chiffrer et stocker le code
        $user->forceFill([
            'two_factor_secret' => encrypt($code),
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();
        
        return $code;
    }

    /**
     * Vérifie si le code saisi est valide
     */
    public function verifyCode(string $inputCode, string $email): bool
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return false;
        }
        
        // Vérifier l'expiration
        if ($user->two_factor_expires_at && \Carbon\Carbon::parse($user->two_factor_expires_at)->isPast()) {
            return false;
        }
        
        // Vérifier le code principal
        if ($user->two_factor_secret) {
            try {
                $storedCode = decrypt($user->two_factor_secret);
                if ($storedCode === $inputCode) {
                    // Marquer comme confirmé
                    $user->forceFill([
                        'two_factor_confirmed_at' => now(),
                    ])->save();
                    return true;
                }
            } catch (\Exception $e) {
                // Le code n'est pas chiffré ou est invalide
            }
        }
        
        // Vérifier les codes de récupération
        if ($user->two_factor_recovery_codes) {
            try {
                $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
                
                if (is_array($recoveryCodes) && in_array($inputCode, $recoveryCodes)) {
                    // Retirer le code utilisé
                    $recoveryCodes = array_values(array_diff($recoveryCodes, [$inputCode]));
                    
                    $user->forceFill([
                        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
                        'two_factor_confirmed_at' => now(),
                    ])->save();
                    
                    return true;
                }
            } catch (\Exception $e) {
                // Les codes de récupération ne sont pas valides
            }
        }
        
        return false;
    }

    /**
     * Envoie le code par email
     */
    public function sendCodeByEmail(User $user, string $code): void
    {
        Mail::to($user->email)->send(new TwoFactorCodeMail($code));
    }

    /**
     * Génère des codes de récupération
     */
    public function generateRecoveryCodes(int $count = 8): array
    {
        $codes = [];
        
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtolower(Str::random(10));
        }
        
        return $codes;
    }

    /**
     * Stocke les codes de récupération pour un utilisateur
     */
    public function storeRecoveryCodes(User $user, array $codes): void
    {
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($codes)),
        ])->save();
    }
}
