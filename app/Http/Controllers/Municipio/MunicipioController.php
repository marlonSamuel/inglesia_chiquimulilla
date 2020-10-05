<?php

namespace App\Http\Controllers\Municipio;

use App\Municipio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class MunicipioController extends ApiController
{
    public function __construct(){
        #parent::__construct();
    }

    public function index(){
        $data = Municipio::with('departamento')->get();
        return $this->showAll($data);
    }
}
