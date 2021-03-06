<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(RolSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(ParrocoSeeder::class);
        $this->call(ParroquiaSeeder::class);
        $this->call(FeligresSeeder::class);
    }
}
