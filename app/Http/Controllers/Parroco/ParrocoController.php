<?php

namespace App\Http\Controllers\Parroco;

use App\Parroco;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ParrocoController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        #$this->middleware('scope:parroco')->except(['index']);
    }
    public function index()
    {
        $parroco = Parroco::with('municipio.departamento')->get();
        return $this->showAll($parroco);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'numero' => 'required',
            'primer_nombre' => 'required', 
            'primer_apellido' => 'required'
        ];

        $this->validate($request, $reglas);

        $data = $request->all();
        $parroco = Parroco::create($data);

        return $this->showOne($parroco, 201);
    }

    public function show(parroco $parroco)
    { 
        return $this->showOne($parroco);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\parroco  $parroco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, parroco $parroco)
    {
        $reglas = [
            'numero' => 'required',
            'primer_nombre' => 'required', 
            'primer_apellido' => 'required'
        ];

        $this->validate($request, $reglas);

        $parroco->numero = $request->numero;
        $parroco->primer_nombre = $request->primer_nombre;
        $parroco->segundo_nombre = $request->segundo_nombre;
        $parroco->primer_apellido = $request->primer_apellido;
        $parroco->segundo_apellido = $request->segundo_apellido;

        if (!$parroco->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $parroco->save();

        return $this->showOne($parroco);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\parroco  $parroco
     * @return \Illuminate\Http\Response
     */
    public function destroy(parroco $parroco)
    {
        $parroco->delete();
        return $this->showOne($parroco);
    }
}
