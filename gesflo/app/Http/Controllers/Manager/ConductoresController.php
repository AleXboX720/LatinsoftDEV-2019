<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Responsables\Conductores\Vistas\Home;
use App\Http\Responsables\Conductores\Vistas\Crear;
use App\Http\Responsables\Conductores\Vistas\Editar;

use App\Http\Responsables\Conductores\Buscar;
use App\Http\Responsables\Conductores\Eliminar;
use App\Http\Responsables\Conductores\Actualizar;
use App\Http\Responsables\Conductores\Guardar;
use App\Http\Responsables\Conductores\Listar;
use App\Http\Responsables\Conductores\Filtrar;

class ConductoresController extends Controller
{
    public function index(Request $request)
    {
        return new Home($request); 
    }

    public function buscar(Request $request)
    {
        return new Buscar($request);
    }

    public function crear(Request $request)
    {
        return new Crear($request);
    }

    public function editar(Request $request)
    {
        return new Editar($request);
    }
    /*----------------------------------------------------------------------*/
    public function guardar(Request $request)
    {
        return new Guardar($request);
    }
    /*----------------------------------------------------------------------*/
    public function actualizar(Request $request)
    {
        return new Actualizar($request);
    }

    public function eliminar(Request $request)
    {
        return new Eliminar($request);
    }
    /*----------------------------------------------------------------------*/
    public function listarConductores(Request $request)
    {
        return new Listar($request); 
    }
    
    public function filtrarConductor(Request $request)
    {    
        return new Filtrar($request);
    }
}