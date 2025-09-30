<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cette adresse email.']);
        }

        // Générer un mot de passe aléatoire de 8 chiffres
        $password = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        
        // Mettre à jour le mot de passe de l'utilisateur
        $user->password = Hash::make($password);
        $user->first_use= 1;
        $user->save();

        // Envoyer l'email avec le nouveau mot de passe
        $user->notify(new ResetPasswordNotification($password));

        return back()->with('status', 'Un nouveau mot de passe a été envoyé à votre adresse email.');
    }
}
