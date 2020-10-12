<?php

namespace App;

use App\Municipio;
use App\Parroquia;
use Illuminate\Database\Eloquent\Model;

class Feligrese extends Model
{
    protected $table = 'feligreses';

    protected $fillable= [
        'telefono',
    	'primer_nombre',
    	'segundo_nombre',
    	'primer_apellido',
    	'segundo_apellido',
    	'direccion',
    	'municipio_id',
    	'parroquia_id',
        'fecha_nac'
    ];

    public function municipio(){
    	return $this->belongsTo(Municipio::class);
    }

    public function parroquia(){
    	return $this->belongsTo(Parroquia::class);
    }
}
