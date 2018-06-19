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
        $status = json_decode(file_get_contents('http://192.168.0.106/status'), true);
        // $status = file_get_contents('http://192.168.0.106/status');
        $alarmeAtivo = $status['ativo'];
        return view('home', compact('alarmeAtivo'));
    }

    public function ativar()
    {
        file_get_contents('http://192.168.0.106/ativar');
        return redirect()->route('home');
    }

    public function desativar()
    {
        file_get_contents('http://192.168.0.106/desativar');
        return redirect()->route('home');
    }


}
