<?php

namespace App\Http\Controllers\Confirmacion;

use App\Libro;
use Carbon\Carbon;
use App\Confirmacione;
use Barryvdh\DomPDF\PDF;
use App\ParrocoParroquia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class ConfirmacionController extends ApiController
{
   public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $confirmaciones = Confirmacione::with('padre','madre','padrino1','padrino2','libro','confirmado','parroquia')->get();

        return $this->showAll($confirmaciones);
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
            'padrino2_id'=>'required',
            'parroquia_id'=>'required'
        ];

        $this->validate($request, $reglas);

        DB::beginTransaction();
            $data = $request->all();

            $parroco_parroquia = ParrocoParroquia::where('principal',true)->first();

            $data['parroco_parroquia_id'] = $parroco_parroquia->id;
            $confirmacione = Confirmacione::create($data);

            $libro = Libro::find($request->libro_id);
            $libro->folio_actual = $request->folio;
            $libro->partida_actual = $request->partida;

            if($libro->partida_actual+1 > 3){
                $libro->partida_actual = 0;
                $libro->folio_actual+=1;
            }
            
            if($libro->no_folios == $libro->folio_actual){
                $libro->terminado = true;
            }
            $libro->save();
        DB::commit();

        return $this->showOne($confirmacione, 201);
    }

    public function show(Confirmacione $confirmacione)
    { 
        return $this->showOne($confirmacione);
    }

    public function update(Request $request, Confirmacione $confirmacione)
    {
        $reglas = [
            'folio'=>'required',
            'partida'=>'required',
            'fecha'=>'required',
            'libro_id'=>'required',
            'padre_id'=>'required',
            'madre_id'=>'required',
            'padrino1_id'=>'required',
            'padrino2_id'=>'required',
            'parroquia_id'=>'required'
        ];

        $this->validate($request, $reglas);

        $confirmacione->fecha = $request->fecha;
        $confirmacione->folio = $request->folio;
        $confirmacione->partida = $request->partida;
        $confirmacione->fecha = $request->fecha;
        $confirmacione->libro_id = $request->libro_id;
        $confirmacione->padre_id = $request->padre_id;
        $confirmacione->madre_id = $request->madre_id;
        $confirmacione->padrino1_id = $request->padrino1_id;
        $confirmacione->padrino2_id = $request->padrino2_id;
        $confirmacione->monsenior = $request->monsenior;
        $confirmacione->parroquia_id = $request->parroquia_id;

        if (!$confirmacione->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $confirmacione->save();

        return $this->showOne($confirmacione);
    }

    public function destroy(Confirmacione $confirmacione)
    {
        DB::beginTransaction();
            $confirmacione->delete();
            $libro = Libro::find($confirmacione->libro_id);

            if($libro->folio_actual == 1 && $libro->partida_actual == 1){
                $libro->folio_actual = 0;
                $libro->partida_actual = 0;
            }else if($libro->partida_actual == 1){
                $libro->partida_actual = 0;
            }else if($libro->partida_actual == 0){
                $libro->partida_actual = 2;
                $libro->folio_actual-=1;
            }else{
                $libro->partida_actual-=1;
            }
            
            if($libro->no_folios > $libro->folio_actual){
                $libro->terminado = false;
            }
            $libro->save();
        DB::commit();
        return $this->showOne($confirmacione);
    }

    public function pdf($id)
    {
        $confirmacione = Confirmacione::where('id',$id)->with('padre','madre','padrino1','padrino2','libro','confirmado','parroco_parroquia.parroco','parroquia')->first();

        $age = Carbon::parse($confirmacione->confirmado->fecha_nac)->age;

        $pdf = \PDF::loadView('pdfs.confirmacion',['confirmacion'=>$confirmacione,'age'=>$age]);

        $pdf->setPaper('legal', 'portrait');

        return $pdf->download('ejemplo.pdf');
    }

     public function print($from,$to){
        if($from != 0 & $to != 0){
            $confirmaciones = Confirmacione::whereBetween('fecha', [$from, $to])->with('padre','madre','confirmado.municipio.departamento','padrino1','padrino2')->get();
        }else{
            $confirmaciones = Confirmacione::with('padre','madre','confirmado.municipio.departamento','padrino1','padrino2')->get();
        }

        foreach ($confirmaciones as $b) {
            $b->nombres = $b->confirmado->primer_nombre.' '.$b->confirmado->segundo_nombre.' '.$b->confirmado->primer_apellido.' '.$b->confirmado->segundo_apellido;

            $b->padres = $b->padre->primer_nombre.' '.$b->padre->segundo_nombre.' '.$b->padre->primer_apellido.' '.$b->padre->segundo_apellido.' y '. $b->madre->primer_nombre.' '.$b->madre->segundo_nombre.' '.$b->madre->primer_apellido.' '.$b->madre->segundo_apellido;

            $b->padrinos = $b->padrino1->primer_nombre.' '.$b->padrino1->segundo_nombre.' '.$b->padrino1->primer_apellido.' '.$b->padrino1->segundo_apellido.' y '. $b->padrino2->primer_nombre.' '.$b->padrino2->segundo_nombre.' '.$b->padrino2->primer_apellido.' '.$b->padrino2->segundo_apellido;

            $b->age = Carbon::parse($b->confirmado->fecha_nac)->age;

            $b->direccion = $b->confirmado->direccion.' '.$b->confirmado->municipio->nombre. ' '.$b->confirmado->municipio->departamento->nombre;
        }

        $pdf = \PDF::loadView('pdfs.confirmaciones',['confirmaciones'=>$confirmaciones,'from'=>$from,'to'=>$to])->setPaper('a4', 'landscape');

        return $pdf->download('confirmaciones.pdf');
    }
}
