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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $link = config('app.arduino').'/status?token='.config('app.token');

        $status = json_decode(file_get_contents($link), true);

        // $status = file_get_contents('http://192.168.0.106/status');
        $alarmeAtivo = $status['ativo'];
        return view('home', compact('alarmeAtivo'));
    }

    public function ativar()
    {
        $link = config('app.arduino').'/ativar?token='.config('app.token');
        file_get_contents($link);
        return redirect()->route('home');
    }

    public function desativar()
    {
        $link = config('app.arduino').'/desativar?token='.config('app.token');
        file_get_contents($link);
        return redirect()->route('home');
    }


}
