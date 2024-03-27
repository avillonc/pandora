<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Egresados; 

class EgresadoController extends Controller
{
     
    
    public function rptEgresadosMinisterio(Request $request)
    { 
        $data = Egresados::rptEgresadosMinisterio($request);
        return response($data, Response::HTTP_OK);
    }
    public function getTermcode(Request $request)
    {
        $data = Egresados::getTermcode($request);
        return response($data, Response::HTTP_OK);
    }
    public function getCarreraAllByNivel(Request $request)
    {
        $data = Egresados::getCarreraAllByNivel($request);
        return response($data, Response::HTTP_OK);
    }
    public function getMaestras(Request $request)
    {
        $data = Egresados::getMaestras($request);
        return response($data, Response::HTTP_OK);
    }
}
