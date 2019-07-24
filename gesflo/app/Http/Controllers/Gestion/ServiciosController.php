<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Responsables\Vistas\Servicios\Home;

use App\Http\Responsables\Modulos\BuscarServicio;
use App\Http\Responsables\Modulos\BuscarMovil;
use App\Http\Responsables\Modulos\BuscarConductor;
use App\Http\Responsables\Modulos\ListarServicios;
use App\Http\Responsables\Modulos\FiltrarServicios;
use App\Http\Responsables\Modulos\EliminarServicio;
use App\Http\Responsables\Modulos\RegistrarServicio;
use App\Http\Responsables\Modulos\AnalizarServicios;
use App\Http\Responsables\Modulos\ProcesarServicios;

use App\Http\Controllers\Imprimir\ServiciosController as ImprimirServicio;

class ServiciosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return new Home($request); 
    }

    public function buscar(Request $request)
    {
        return new BuscarServicio($request);
    }

	public function listar(Request $request)
    {
        return new ListarServicios($request);
    }

    public function filtrar(Request $request)
    {
        return new FiltrarServicios($request);
    }

    public function eliminar(Request $request)
    {
        return new EliminarServicio($request);
    }

    public function registrar(Request $request)
    {
        return new RegistrarServicio($request);
    }
    /*--------------------------------------------------*/
    public function analizarServicios(Request $request)
    {
        return new AnalizarServicios($request);
    }

    public function procesarServicio(Request $request)
    {
        return new ProcesarServicios($request);
    }
    /*--------------------------------------------------*/
    public function buscarMovil(Request $request)
    {
        return new BuscarMovil($request);
    }

    public function buscarConductor(Request $request)
    {
        return new BuscarConductor($request);
    }
}