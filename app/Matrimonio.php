<?php

namespace App;

use App\Libro;
use App\Feligrese;
use App\Parroquia;
use App\ParrocoParroquia;
use Illuminate\Database\Eloquent\Model;

class Matrimonio extends Model
{
    protected $table = 'matrimonios';


    protected $fillable = [
        'novio_id',
        'novia_id',
    	'folio',
    	'testigos',
    	'partida',
    	'fecha',
    	'libro_id',
    	'padre_novia_id',
    	'madre_novia_id',
    	'padre_novio_id',
    	'madre_novio_id',
    	'parroco_parroquia_id',
    	'parroquia_novia_id',
    	'parroquia_novio_id'
    ];

    public function padre_novia(){
    	return $this->belongsTo(Feligrese::class,'padre_novia_id');
    }

    public function madre_novia(){
    	return $this->belongsTo(Feligrese::class,'madre_novia_id');
    }

    public function padre_novio(){
    	return $this->belongsTo(Feligrese::class,'padre_novia_id');
    }

    public function madre_novio(){
    	return $this->belongsTo(Feligrese::class,'madre_novio_id');
    }

    public function libro(){
        return $this->belongsTo(Libro::class,'libro_id');
    }

    public function novio(){
        return $this->belongsTo(Feligrese::class,'novio_id');
    }

    public function novia(){
        return $this->belongsTo(Feligrese::class,'novia_id');
    }

    public function parroco_parroquia(){
        return $this->belongsTo(ParrocoParroquia::class,'parroco_parroquia_id');
    }

    public function parroquia_novio(){
        return $this->belongsTo(Parroquia::class,'parroquia_novio_id');
    }

    public function parroquia_novia(){
        return $this->belongsTo(Parroquia::class,'parroquia_novia_id');
    }
}
