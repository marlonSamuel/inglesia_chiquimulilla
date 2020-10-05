<?php

namespace App;

use App\Departamento;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';

    protected $fillable = ['nombre'];

    public function departamento(){
    	return $this->belongsTo(Departamento::class);
    }
}
