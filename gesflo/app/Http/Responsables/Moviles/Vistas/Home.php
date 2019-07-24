<?php

namespace App\Http\Responsables\Moviles\Vistas;

use Illuminate\Contracts\Support\Responsable;


class Home implements Responsable
{

    public function __construct($request)
    {
    }

    public function toResponse($request)
    { 
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Moviles',
            'buscare'   => 'pate_movil',
        ];
        return view('manager.moviles.vista', compact('data'));
    }
}