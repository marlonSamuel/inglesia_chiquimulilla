<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parroco extends Model
{
    protected $table = 'parrocos';

    protected $fillable = [
    	'numero',
    	'primer_nombre',
    	'segundo_nombre',
    	'primer_apellido',
    	'segundo_apellido',
    	'direccion',
    	'municipio_id'
    ];

    public function municipio(){
    	return $this->belongsTo(Municipio::class);
    }
}
