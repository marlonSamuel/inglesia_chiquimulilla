<?php

namespace App\Http\Controllers\Bautizo;

use App\Libro;
use App\Bautizo;
use Barryvdh\DomPDF\PDF;
use App\ParrocoParroquia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class BautizoController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $bautizos = Bautizo::with('padre','madre','padrino1','padrino2','libro','bautizado')->get();

        return $this->showAll($bautizos);
    }

    public function store(Request $request)
    {
        $reglas = [
            'feligres_id'=>'required',
            'folio'=>'required',
            'partida'=>'required',
            'fecha'=>'required',
            'libro_id'=>'required',
            'padre_id'=>'required',
            'madre_id'=>'required',
            'padrino1_id'=>'required',
            'padrino2_id'=>'required'
        ];

        $this->validate($request, $reglas);

        DB::beginTransaction();
            $data = $request->all();

            $parroco_parroquia = ParrocoParroquia::where('principal',true)->first();

            $data['parroco_parroquia_id'] = $parroco_parroquia->id;
            $bautizo = Bautizo::create($data);

            $libro = Libro::find($request->libro_id);
            $libro->folio_actual = $request->folio;
            $libro->partida_actual = $request->partida;

            if($libro->partida_actual+1 > 3){
                $libro->partida_actual = 1;
                $libro->folio_actual+=1;
            }
            
            if($libro->no_folios == $libro->folio_actual){
                $libro->terminado = true;
            }
            $libro->save();
        DB::commit();

        return $this->showOne($bautizo, 201);
    }

    public function show(Bautizo $bautizo)
    { 
        return $this->showOne($bautizo);
    }

    public function update(Request $request, Bautizo $bautizo)
    {
        $reglas = [
            'folio'=>'required',
            'partida'=>'required',
            'fecha'=>'required',
            'libro_id'=>'required',
            'padre_id'=>'required',
            'madre_id'=>'required',
            'padrino1_id'=>'required',
            'padrino2_id'=>'required'
        ];

        $this->validate($request, $reglas);

        $bautizo->fecha = $request->fecha;
        $bautizo->folio = $request->folio;
        $bautizo->partida = $request->partida;
        $bautizo->fecha = $request->fecha;
        $bautizo->libro_id = $request->libro_id;
        $bautizo->padre_id = $request->padre_id;
        $bautizo->madre_id = $request->madre_id;
        $bautizo->padrino1_id = $request->padrino1_id;
        $bautizo->padrino2_id = $request->padrino2_id;

        if (!$bautizo->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $bautizo->save();

        return $this->showOne($bautizo);
    }

    public function destroy(Bautizo $bautizo)
    {
        DB::beginTransaction();
            $bautizo->delete();
            $libro = Libro::find($bautizo->libro_id);

            if($libro->folio_actual == 1 && $libro->partida_actual == 1){
                $libro->folio_actual = 0;
                $libro->partida_actual = 0;
            }else if($libro->partida_actual == 1){
                $libro->partida_actual = 3;
                $libro->folio_actual-=1;
            }else{
                $libro->partida_actual-=1;
            }
            
            if($libro->no_folios > $libro->folio_actual){
                $libro->terminado = false;
            }
            $libro->save();
        DB::commit();
        return $this->showOne($bautizo);
    }

    public function pdf($id)
    {
        $bautizo = Bautizo::where('id',$id)->with('padre','madre','padrino1','padrino2','libro','bautizado','parroco_parroquia.parroco')->first();

        $pdf = \PDF::loadView('pdfs.bautizo',['bautizo'=>$bautizo]);

        $pdf->setPaper('legal', 'portrait');

        return $pdf->download('ejemplo.pdf');
    }

    public function print($from,$to){
        if($from != 0 & $to != 0){
            $bautizos = Bautizo::whereBetween('fecha', [$from, $to])->with('padre','madre','bautizado.municipio.departamento','padrino1','padrino2')->get();
        }else{
            $bautizos = Bautizo::with('padre','madre','bautizado.municipio.departamento','padrino1','padrino2')->get();
        }

        foreach ($bautizos as $b) {
            $b->nombres = $b->bautizado->primer_nombre.' '.$b->bautizado->segundo_nombre.' '.$b->bautizado->primer_apellido.' '.$b->bautizado->segundo_apellido;

            $b->padres = $b->padre->primer_nombre.' '.$b->padre->segundo_nombre.' '.$b->padre->primer_apellido.' '.$b->padre->segundo_apellido.' y '. $b->madre->primer_nombre.' '.$b->madre->segundo_nombre.' '.$b->madre->primer_apellido.' '.$b->madre->segundo_apellido;

            $b->padrinos = $b->padrino1->primer_nombre.' '.$b->padrino1->segundo_nombre.' '.$b->padrino1->primer_apellido.' '.$b->padrino1->segundo_apellido.' y '. $b->padrino2->primer_nombre.' '.$b->padrino2->segundo_nombre.' '.$b->padrino2->primer_apellido.' '.$b->padrino2->segundo_apellido;

            $b->direccion = $b->bautizado->direccion.' '.$b->bautizado->municipio->nombre. ' '.$b->bautizado->municipio->departamento->nombre;
        }

        #pdf bautizos
        $pdf = \PDF::loadView('pdfs.bautizos',['bautizos'=>$bautizos,'from'=>$from,'to'=>$to])->setPaper('a4', 'landscape');

        return $pdf->download('bautizos.pdf');
    }
}
