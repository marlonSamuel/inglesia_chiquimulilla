<?php

namespace App;

use App\Libro;
use App\Feligrese;
use App\Parroquia;
use App\ParrocoParroquia;
use Illuminate\Database\Eloquent\Model;

class Confirmacione extends Model
{
    protected $table = 'confirmaciones';

    protected $fillable = [
        'feligres_id',
    	'folio',
    	'monsenior',
    	'partida',
    	'fecha',
    	'libro_id',
    	'padre_id',
    	'madre_id',
    	'padrino1_id',
    	'padrino2_id',
    	'parroco_parroquia_id',
    	'parroquia_id'
    ];

    public function padre(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function madre(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function padrino1(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function padrino2(){
    	return $this->belongsTo(Feligrese::class,'padre_id');
    }

    public function libro(){
        return $this->belongsTo(Libro::class,'libro_id');
    }

    public function confirmado(){
        return $this->belongsTo(Feligrese::class,'feligres_id');
    }

    public function parroco_parroquia(){
        return $this->belongsTo(ParrocoParroquia::class,'parroco_parroquia_id');
    }

    public function parroquia(){
        return $this->belongsTo(Parroquia::class,'parroquia_id');
    }
}
