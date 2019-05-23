<?php

use Illuminate\Database\Seeder;

class OnibusIntermunicipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('onibus_intermunicipal')->insert([
            'id' => 1,
            'qnt_assento' => 50,
            'banheiro' => false,
            'categoria_onibus_id' => 3,
        ]);

        DB::table('onibus')->insert([
            'id' => 1,
            'description_id' => 1,
            'description_type' => 'App\OnibusIntermunicipal',
            'acessibilidade' => false,
            'chassi' => 'G2L5CH64R7K85G5KA',
            'placa' => 'VOG5600',
            'marca' => 'Mercedes Benz',
            'modelo' => 'KL 3201',
            'data_fabricacao' => now(),
            'data_compra' => now(),
        ]);

    }
}
