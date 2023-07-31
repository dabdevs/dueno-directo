<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')
            ->insert([
            [
                'code' => 'AR',
                'name' => 'Argentina'
            ],
            [
                'code' => 'BR',
                'name' => 'Brasil'
            ],
            [
                'code' => 'CHL',
                'name' => 'Chile'
            ],
            [
                'code' => 'USA',
                'name' => 'Estados Unidos'
            ],
            [
                'code' => 'URU',
                'name' => 'Uruguay'
            ],
        ]);
    }
}
