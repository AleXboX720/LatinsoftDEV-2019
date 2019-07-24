<?php

namespace App\Http\Controllers;

use App\Http\Responsables\Vistas\PlanOperacional;
use App\Http\Responsables\Vistas\FrecuenciaServicios;
use App\Http\Responsables\Vistas\RegularidadServicios;

use Illuminate\Http\Request;

class MonitorController extends Controller
{
	public function planOperacional(Request $request)
    {
        return new PlanOperacional($request);
    }
    
    public function frecuenciaServicios(Request $request)
    {
        return new FrecuenciaServicios($request);
    }

    public function regularidadServicios(Request $request)
    {
        return new RegularidadServicios($request);
    }
}