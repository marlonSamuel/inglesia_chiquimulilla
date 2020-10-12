<?php

namespace App\Http\Controllers\Parroco;

use App\ParrocoParroquia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ParrocoParroquiaController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        #$this->middleware('scope:parroco')->except(['index']);
    }
    public function index()
    {
        $parroco = ParrocoParroquia::where('actual',true)->with('parroco','parroquia')->get();
        return $this->showAll($parroco);
    }
}
