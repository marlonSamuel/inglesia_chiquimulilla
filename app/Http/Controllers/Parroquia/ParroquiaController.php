<?php

namespace App\Http\Controllers\Parroquia;

use App\Parroco;
use App\Parroquia;
use App\ParrocoParroquia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class ParroquiaController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        #$this->middleware('scope:parroquia')->except(['index']);
    }
    public function index()
    {
        $parroquias = Parroquia::with('municipio.departamento','parroco.parroco')->get();
        return $this->showAll($parroquias);
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
            'nombre' => 'required',
            'direccion' => 'required',
            'municipio_id' => 'required'
        ];

        $this->validate($request, $reglas);

        DB::beginTransaction();
            $data = $request->all();
            if($request->nuevo){

                $exists = Parroco::where('numero',$request->parroco['numero'])->first();
                if(!is_null($exists)){
                    return $this->errorResponse('numero de parroco ya existe, por favor seleccione otro',421);
                }

                $parroco = new Parroco;
                $parroco->numero = $request->parroco['numero'];
                $parroco->primer_nombre = $request->parroco['primer_nombre'];
                $parroco->segundo_nombre = $request->parroco['segundo_nombre'];
                $parroco->primer_apellido = $request->parroco['primer_apellido'];
                $parroco->segundo_apellido = $request->parroco['segundo_apellido'];
                $parroco->municipio_id = $request->parroco['municipio_id'];
                $parroco->direccion = $request->parroco['direccion'];
                $parroco->save();

                $request->parroco_id = $parroco->id;
            }

            $parroquia = Parroquia::create($data);

            $parroco_parroquia = new ParrocoParroquia;
            $parroco_parroquia->parroquia_id = $parroquia->id;
            $parroco_parroquia->parroco_id = $request->parroco_id;

            $parroco_parroquia->save();

        DB::commit();

        return $this->showOne($parroquia, 201);
    }

    public function show(parroquia $parroquia)
    { 
        return $this->showOne($parroquia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        $reglas = [
            'nombre' => 'required',
            'direccion' => 'required', 
            'municipio_id' => 'required'
        ];

        $this->validate($request, $reglas);

        $parroquia->nombre = $request->nombre;
        $parroquia->direccion = $request->direccion;
        $parroquia->municipio_id = $request->municipio_id;
        $parroquia->cp = $request->cp;
        $parroquia->telefono = $request->telefono;

        $parroco = $parroquia->parroco;

        if($parroco->parroco_id != $request->parroco_id){
            $parroco->actual = false;
            $parroco->save();

            $new_parroco = new ParrocoParroquia;
            $new_parroco->parroco_id = $request->parroco_id;
            $new_parroco->parroquia_id = $parroquia->id;
            $new_parroco->save();
        }else{
            if (!$parroquia->isDirty()) {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
            }
        }

        $parroquia->save();

        return $this->showOne($parroquia);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parroquia $parroquia)
    {
        $parroquia->delete();
        return $this->showOne($parroquia);
    }
}
