<?php

namespace App\Http\Controllers\Admin;
use App\Http\Responsables\Vistas\HomeAdministracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministracionController extends Controller
{
    public function index(Request $request)
    {
    	return new HomeAdministracion($request);
    }

}