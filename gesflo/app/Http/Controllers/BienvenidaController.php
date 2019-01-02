<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BienvenidaController extends Controller
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
        $data = 
        [
            'title'     => 'Bienvenidos a ',
            'subtitle'  => 'Gestra v2018.2'
        ];

        return view('bienvenida', compact('data'));
    }
}