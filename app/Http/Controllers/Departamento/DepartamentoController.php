<?php

namespace App\Http\Controllers\Departamento;

use App\Departamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class DepartamentoController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $data = Departamento::with('municipios')->get();
        return $this->showAll($data);
    }
}
