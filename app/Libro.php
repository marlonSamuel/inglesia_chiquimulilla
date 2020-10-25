<?php

namespace App;

use App\Bautizo;
use App\Matrimonio;
use App\Confirmacione;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
    	'no_libro',
    	'no_folios',
    	'partidas',
    	'folio_actual',
    	'partida_actual',
    	'tipo_libro',
    	'terminado'
    ];

    public function bautizos(){
        return $this->hasMany(Bautizo::class,'libro_id');
    }

    public function confirmaciones(){
        return $this->hasMany(Confirmacione::class,'libro_id');
    }

    public function matrimonios(){
        return $this->hasMany(Matrimonio::class,'libro_id');
    }
}
