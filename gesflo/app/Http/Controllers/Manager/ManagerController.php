<?php

namespace App\Http\Controllers\Manager;
use App\Http\Responsables\Vistas\HomeManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        return new HomeManager($request);
    }

}