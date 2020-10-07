<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    protected $table = 'parroquias';

    protected $fillable = [
    	'nombre',
    	'direccion',
    	'municipio_id'
    ];

    public function municipio(){
    	return $this->belongsTo(Municipio::class);
    }
    

    public function parroquias(){
    	return $this->hasMany(ParrocoParroquia::class);
    }

    public function parroco(){
    	return $this->hasOne(ParrocoParroquia::class)->where('actual',true);
    }
}
