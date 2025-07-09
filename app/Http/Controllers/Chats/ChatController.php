<?php

namespace App\Http\Controllers\Chats;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = User::where('id', '!=', Auth::user()->id)->get();
        $chats = [];
        $find = User::where('id', Auth::user()->id)->first();

        $idreceve = 0;
        return view('regidoc.pages.courriers.chat', compact('agents', 'chats', 'idreceve', 'find'));
    }

    public function chats($id)
    {
        $idreceve = $id;
        $find = User::where('id', $id)->first();
        $employes = Chat::where('id', '!=', Auth::user()->id)->where('user_send', $id)->orwhere('user_receve', $id)->get();

        $agents = User::where('id', '!=', Auth::user()->id)->get();
        $chats = Chat::where('user_send', $id)->orwhere('user_receve', $id)->get();
        $updates = Chat::where('user_receve', Auth::user()->id)->where('user_send', $id)->where('read_at', null)->get();
        foreach ($updates as $update) {
            $updates = Chat::where('id', $update->id)->first()->update([
                'read_at' => now()->format('d-m-y H:i')
            ]);
        }

        return view('regidoc.pages.courriers.chat', compact('agents', 'chats', 'employes', 'idreceve', 'find'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}