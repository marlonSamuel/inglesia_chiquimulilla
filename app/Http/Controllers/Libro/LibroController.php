<?php

namespace App\Http\Controllers\Libro;

use App\Libro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class LibroController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $libros = Libro::all();
        return $this->showAll($libros);
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
            'no_folios' => 'required',
            'partidas' => 'required',
            'tipo_libro'=>'required'
        ];

        $this->validate($request, $reglas);

        $data = $request->all();
        $c_libros = Libro::where('tipo_libro',$request->tipo_libro)->count();
        $data['no_libro'] = $c_libros+1;
        $libro = Libro::create($data);

        return $this->showOne($libro, 201);
    }

    public function show(Libro $libro)
    { 
        if($libro->tipo_libro == 'B'){
            $libro = $libro->with('bautizos')->firstOrFail();
        }else if($libro->tipo_libro == 'C'){
            $libro = $libro->with('confirmaciones')->firstOrFail();
        }else {
            $libro = $libro->with('matrimonios')->firstOrFail();
        }

        return $this->showQuery($libro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        $reglas = [
            'no_folios' => 'required',
            'partidas' => 'required'
        ];

        $this->validate($request, $reglas);

        $libro->no_folios = $request->no_folios;
        $libro->partidas = $request->partidas;

        if (!$libro->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $libro->save();

        return $this->showOne($libro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return $this->showOne($libro);
    }

     public function print($id){

        $pdf = \PDF::loadView('pdfs.libro_bautizos',[])->setPaper('a4', 'landscape');

        return $pdf->download('libro_bautizos.pdf');
    }
}
