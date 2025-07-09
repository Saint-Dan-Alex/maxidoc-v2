<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use Yadahan\AuthenticationLog\AuthenticationLog;

class LogSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'logs' => AuthenticationLog::all()
        ];
        return view('regidoc.pages.systems.log-session', $data);
    }

}
