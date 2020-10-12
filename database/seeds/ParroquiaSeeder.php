<?php

use App\Parroquia;
use App\ParrocoParroquia;
use Illuminate\Database\Seeder;

class ParroquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Parroquia;
        $data->nombre = 'Parroquia Santa Cruz Chiquimulilla';
        $data->direccion = 'calle principal chiquimulilla';
        $data->cp = '06008';
        $data->telefono = '78850193';
        $data->municipio_id = 1;
        $data->save();

        $data2 = new ParrocoParroquia;
        $data2->parroco_id = 1;
        $data2->parroquia_id = 1;
        $data2->actual = 1;
        $data2->principal = 1;
        $data2->save();
    }
}
