<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;

class AuthenticationController extends Controller
{

    public function authorization(Request $request)
    {
        try{
            $encryptedKey = $request->get('token');

            if ($encryptedKey) {
                // Decrypt the key to get the access token
                $decryptedKey = Crypt::decrypt($encryptedKey);
                [$accessTokenId, $user_id] = explode('|', $decryptedKey);

                // Retrieve the user associated with the access token
                $user = User::where('id', $user_id)->first();

                // Retrieve the access token associated with the user
                $accessToken = $user->tokens()->latest()->first();

                // Check if the access token is valid
                if ($accessToken && !$accessToken->revoked) {
                    // Authenticate the user
                    if (!Auth::check()) {
                        Auth::login($user);
                    }

                    // Regenerate the session
                    request()->session()->regenerate(true);
                    // Store custom session value
                    request()->session()->put('laravel_session', $accessTokenId);

                    // Redirect to the desired route
                    return redirect()->route('regidoc.home');

                } else {
                    return response()->json([
                        'statut' => 'error',
                        'code' => 422,
                        'message' => 'Token invalide ou révoqué',
                    ], 422);
                }
            }

        }catch(\Exception $e){
            return response()->json([
                'statut' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statut' => 'error',
                'code' => 422,
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Auth::login($user);
            $token = $user->createToken($user->email)->accessToken;

            $key = Crypt::encrypt($token . '|' . $user->id);
            $data = [
                'statut' => 'success',
                'code' => 200,
                'message' => 'Utilisateur connecté avec succès',
                'token' => $key,
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'statut' => 'fail',
                'code' => 404,
                'message' => 'Cet utilisateur n\'existe pas',
            ], 404);
        }

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if($user){

            foreach ($user->tokens()->get() as $token) {
                $token->revoke();
            }
            Auth::logout($user);
            return response()->json([
                'statut' => 'success',
                'code' => 200,
                'message' => 'Utilisateur deconnecté avec succès',
            ], 200);
        }else{
            return response()->json([
                'statut' => 'fail',
                'code' => 404,
                'message' => 'Cet utilisateur n\'existe pas ou est inactif',
            ], 404);
        }
    }
}
