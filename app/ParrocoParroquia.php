<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParrocoParroquia extends Model
{
    protected $table = 'parroco_parroquias';

    protected $fillable = [
    	'parroco_id',
    	'parroquia_id',
    	'actual'
    ];

    public function parroco(){
    	return $this->belongsTo(Parroco::class);
    }

    public function parroquia(){
    	return $this->belongsTo(Parroquia::class);
    }
}
