<?php

namespace App;

use App\Bautizo;
use App\Municipio;
use App\Parroquia;
use App\Matrimonio;
use App\Confirmacione;
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

    public function bautizo(){
        return $this->hasOne(Bautizo::class,'feligres_id');
    }

    public function confirmacion(){
        return $this->hasOne(Confirmacione::class,'feligres_id');
    }

    public function matrimonio_novio(){
        return $this->hasMany(Matrimonio::class,'novio_id');
    }

    public function matrimonio_novia(){
        return $this->hasMany(Matrimonio::class,'novia_id');
    }
}
