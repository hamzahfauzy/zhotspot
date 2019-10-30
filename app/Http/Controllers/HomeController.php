<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function runBash()
    {
        exec('/var/www/bash/test.sh ah pptpd ah 192.168.0.10 2>&1');
        exec('/etc/init.d/pptpd restart 2>&1');
        return;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function landing()
    {
        return view('landing');
    }
}
