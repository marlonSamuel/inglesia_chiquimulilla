<?php

namespace App\Http\Controllers\Dashboard;

use App\Libro;
use App\Bautizo;
use App\Feligrese;
use App\Parroquia;
use App\Matrimonio;
use App\Confirmacione;
use App\ParrocoParroquia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class DashboardController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $bautizos = Bautizo::count();
        $confirmaciones = Confirmacione::count();
        $matrimonios = Matrimonio::count();

        $parroquias = Parroquia::count();

        $parroquia = ParrocoParroquia::where('principal',true)->first();

        $feligreses = Feligrese::where('parroquia_id',$parroquia->parroquia_id)->count();

        $libros = Libro::count();

        $values_actividades = [$bautizos,$confirmaciones,$matrimonios];

        return response()->json(
        	[
        		'actividades'=>$values_actividades,
        		'libros'=>$libros,
        		'parroquias'=>$parroquias,
        		'feligreses' => $feligreses
        ], 200);
    }
}
