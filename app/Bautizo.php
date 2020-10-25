<?php

namespace App;

use App\Libro;
use App\Feligrese;
use App\ParrocoParroquia;
use Illuminate\Database\Eloquent\Model;

class Bautizo extends Model
{
    protected $table = 'bautizos';

    protected $fillable = [
        'feligres_id',
    	'folio',
    	'partida',
    	'fecha',
    	'libro_id',
    	'padre_id',
    	'madre_id',
    	'padrino1_id',
    	'padrino2_id',
    	'parroco_parroquia_id',
        'fecha_nacimiento'
    ];

    public function padre(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function madre(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function padrino1(){
    	return $this->belongsTo(Feligrese::class,'padrino1_id');
    }

    public function padrino2(){
    	return $this->belongsTo(Feligrese::class,'padrino2_id');
    }

    public function libro(){
        return $this->belongsTo(Libro::class,'libro_id');
    }

    public function bautizado(){
        return $this->belongsTo(Feligrese::class,'feligres_id');
    }

    public function parroco_parroquia(){
        return $this->belongsTo(ParrocoParroquia::class,'parroco_parroquia_id');
    }
}
