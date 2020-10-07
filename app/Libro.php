<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
    	'no_folios',
    	'partidas',
    	'folio_actual',
    	'partida_actual',
    	'terminado'
    ];
}
