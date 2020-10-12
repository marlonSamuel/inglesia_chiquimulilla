<?php

use App\Feligrese;
use Illuminate\Database\Seeder;

class FeligresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = new Feligrese;
        $data->primer_nombre = 'pablo';
        $data->primer_apellido = 'perez';
        $data->direccion = 'colonia valle dorado';
        $data->municipio_id = 1;
        $data->fecha_nac='2020-06-01';
        $data->parroquia_id = 1;
        $data->save();

    	for ($i = 2; $i<21; $i++){
    		$data = new Feligrese;
        	$data->telefono = '58746576';
        	$data->primer_nombre =  'nombre'.$i;
	        $data->primer_apellido = 'apellido '.$i;
	        $data->direccion = 'direccion '.$i;
	        $data->municipio_id = 1;
	        $data->parroquia_id = 1;
	        $data->fecha_nac='1990-06-01';
	        $data->save();
    	}
        
    }
}
