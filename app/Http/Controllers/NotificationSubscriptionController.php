<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = Auth::user();

        $subscription = $user->agent->updatePushSubscription(
            $request->get('endpoint'),
            ($request->get('keys') ?: [])['p256dh'] ?? null,
            ($request->get('keys') ?: [])['auth'] ?? null,
            $request->get('encoding') ?? null,
        );

        return response()->json(['message' => 'Subscribed!']);
    }

    public function unsubscribe(Request $req)
    {
        $user = User::find(1);

        $user->agent->deletePushSubscription($req->post('endpoint'));

        return response()->json(['message' => 'Unsubscribed!']);
    }

    // public function register(Request $request){
    //     $this->validate($request,[
    //         'endpoint'    => 'required',
    //         'keys.auth'   => 'required',
    //         'keys.p256dh' => 'required'
    //     ]);
    //     $endpoint = $request->endpoint;
    //     $token = $request->keys['auth'];
    //     $key = $request->keys['p256dh'];
    //     $user = Auth::user();
    //     $user->agent->updatePushSubscription($endpoint, $key, $token);
        
    //     return response()->json(['success' => true],200);

    //     // $user = $guard->user();
    //     // return $user->updatePushSubscription(
    //     //     $request->get('endPoint'),
    //     //     ($request->get('keys') ?: [])['p256dh'] ?? null,
    //     //     ($request->get('keys') ?: [])['auth'] ?? null,
    //     // );
    // }

    public function key(){
        return [
            'key' => env('VAPID_PUBLIC_KEY')
        ];
    }
}
