<?php

use App\Parroco;
use Illuminate\Database\Seeder;

class ParrocoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Parroco;
        $data->numero = 'abc-06';
        $data->primer_nombre = 'Juan';
        $data->primer_apellido = 'Perez';
        $data->direccion = 'Colonia valle dorado';
        $data->municipio_id = 1;
        $data->save();
    }
}
