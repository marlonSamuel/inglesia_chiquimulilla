<?php

namespace App\Http\Controllers\Feligrese;

use App\Feligrese;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class FeligreseController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        #$this->middleware('scope:feligrese')->except(['index']);
    }
    public function index()
    {
        $feligreses = Feligrese::with('municipio.departamento','parroquia')->get();
        return $this->showAll($feligreses);
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
            'primer_nombre' => 'required', 
            'primer_apellido' => 'required',
            'municipio_id' => 'required',
            'parroquia_id' => 'required',
            'fecha_nac' =>  'required'
        ];

        $this->validate($request, $reglas);

        $data = $request->all();
        $feligrese = Feligrese::create($data);

        return $this->showOne($feligrese, 201);
    }

    public function show(Feligrese $feligrese)
    { 
        return $this->showOne($feligrese);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\feligrese  $feligrese
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, feligrese $feligrese)
    {
        $reglas = [
            'primer_nombre' => 'required', 
            'primer_apellido' => 'required',
            'municipio_id' => 'required',
            'parroquia_id' => 'required',
            'fecha_nac'=>'required'
        ];

        $this->validate($request, $reglas);

        $feligrese->primer_nombre = $request->primer_nombre;
        $feligrese->segundo_nombre = $request->segundo_nombre;
        $feligrese->primer_apellido = $request->primer_apellido;
        $feligrese->segundo_apellido = $request->segundo_apellido;
        $feligrese->direccion = $request->direccion;
        $feligrese->municipio_id = $request->municipio_id;
        $feligrese->parroquia_id = $request->parroquia_id;
        $feligrese->fecha_nac = $request->fecha_nac;
        $feligrese->telefono = $request->telefono;

        if (!$feligrese->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $feligrese->save();

        return $this->showOne($feligrese);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\feligrese  $feligrese
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feligrese $feligrese)
    {
        $feligrese->delete();
        return $this->showOne($feligrese);
    }
}
