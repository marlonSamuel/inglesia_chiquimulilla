<?php

namespace App\Http\Controllers\Matrimonio;

use App\Libro;
use Carbon\Carbon;
use App\Matrimonio;
use Barryvdh\DomPDF\PDF;
use App\ParrocoParroquia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class MatrimonioController extends ApiController
{
     public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $matrimonios = Matrimonio::with('padre_novio','madre_novio','padre_novia','madre_novia','libro','novio','novia','parroquia_novio','parroquia_novia')->get();

        return $this->showAll($matrimonios);
    }

    public function store(Request $request)
    {
        $reglas = [
            'novio_id'=>'required',
            'novia_id'=>'required',
            'partida'=>'required',
            'fecha'=>'required',
            'libro_id'=>'required',
            'padre_novio_id'=>'required',
            'padre_novia_id'=>'required',
            'madre_novio_id'=>'required',
            'madre_novia_id'=>'required',
            'parroquia_novio_id'=>'required',
            'parroquia_novia_id'=>'required'
        ];

        $this->validate($request, $reglas);

        DB::beginTransaction();
            $data = $request->all();

            $parroco_parroquia = ParrocoParroquia::where('principal',true)->first();

            $data['parroco_parroquia_id'] = $parroco_parroquia->id;
            $matrimonio = Matrimonio::create($data);

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

        return $this->showOne($matrimonio, 201);
    }

    public function show(Matrimonio $matrimonio)
    { 
        return $this->showOne($matrimonio);
    }

    public function update(Request $request, Matrimonio $matrimonio)
    {
        $reglas = [
            'novio_id'=>'required',
            'novia_id'=>'required',
            'partida'=>'required',
            'fecha'=>'required',
            'libro_id'=>'required',
            'padre_novio_id'=>'required',
            'padre_novia_id'=>'required',
            'madre_novio_id'=>'required',
            'madre_novia_id'=>'required',
            'parroquia_novio_id'=>'required',
            'parroquia_novia_id'=>'required'
        ];

        $this->validate($request, $reglas);

        $matrimonio->fecha = $request->fecha;
        $matrimonio->folio = $request->folio;
        $matrimonio->partida = $request->partida;
        $matrimonio->fecha = $request->fecha;
        $matrimonio->libro_id = $request->libro_id;
        $matrimonio->padre_novio_Id = $request->padre_novio_id;
        $matrimonio->padre_novia_id = $request->padre_novia_id;
        $matrimonio->madre_novio_id = $request->madre_novio_id;
        $matrimonio->madre_novia_id = $request->madre_novia_id;
        $matrimonio->parroquia_novio_id = $request->parroquia_novio_id;
        $matrimonio->parroquia_novia_id = $request->parroquia_novia_id;
        $matrimonio->testigos = $request->testigos;

        if (!$matrimonio->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $matrimonio->save();

        return $this->showOne($matrimonio);
    }

    public function destroy(Matrimonio $matrimonio)
    {
        DB::beginTransaction();
            $matrimonio->delete();
            $libro = Libro::find($matrimonio->libro_id);

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
        return $this->showOne($matrimonio);
    }

    public function pdf($id)
    {
        $matrimonio = Matrimonio::where('id',$id)->with('padre_novio','madre_novio','padre_novia','madre_novia','libro','novio.municipio.departamento','novia.municipio.departamento','parroquia_novio','parroquia_novia','parroco_parroquia.parroco','parroco_parroquia.parroquia')->first();

        $age_novio = Carbon::parse($matrimonio->novio->fecha_nac)->age;
        $age_novia = Carbon::parse($matrimonio->novia->fecha_nac)->age;

        //return $this->showQuery($matrimonio);

        $pdf = \PDF::loadView('pdfs.matrimonio',['matrimonio'=>$matrimonio,'age_novio'=>$age_novio,'age_novia'=>$age_novia]);

        $pdf->setPaper('legal', 'portrait');

        return $pdf->download('ejemplo.pdf');
    }

    public function print($from,$to){
        if($from != 0 & $to != 0){
            $confirmaciones = Matrimonio::whereBetween('fecha', [$from, $to])->with('novio.municipio.departamento','novia.municipio.departamento')->get();
        }else{
            $confirmaciones = Matrimonio::with('novio.municipio.departamento','novia.municipio.departamento')->get();
        }

        foreach ($confirmaciones as $b) {
            $b->nombre_novio = $b->novio->primer_nombre.' '.$b->novio->segundo_nombre.' '.$b->novio->primer_apellido.' '.$b->novio->segundo_apellido;

            $b->nombre_novia = $b->novia->primer_nombre.' '.$b->novia->segundo_nombre.' '.$b->novia->primer_apellido.' '.$b->novia->segundo_apellido;

            $b->age_novia = Carbon::parse($b->novia->fecha_nac)->age;
            $b->age_novio = Carbon::parse($b->novio->fecha_nac)->age;

            $b->direccion_novio = $b->novio->direccion.' '.$b->novio->municipio->nombre. ' '.$b->novio->municipio->departamento->nombre;

            $b->direccion_novia = $b->novia->direccion.' '.$b->novia->municipio->nombre. ' '.$b->novia->municipio->departamento->nombre;
        }

        $pdf = \PDF::loadView('pdfs.matrimonios',['matrimonios'=>$confirmaciones,'from'=>$from,'to'=>$to])->setPaper('a4', 'landscape');

        return $pdf->download('matrimonios.pdf');
    }
}
