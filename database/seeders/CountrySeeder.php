<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('countries')
            ->insert([
                [
                    'code' => 'AR',
                    'name' => 'Argentina',
                    'created_at' => now()
                ],
                [
                    'code' => 'BR',
                    'name' => 'Brasil',
                    'created_at' => now()
                ],
                [
                    'code' => 'CHL',
                    'name' => 'Chile',
                    'created_at' => now()
                ],
                [
                    'code' => 'USA',
                    'name' => 'Estados Unidos',
                    'created_at' => now()
                ],
                [
                    'code' => 'URU',
                    'name' => 'Uruguay',
                    'created_at' => now()
                ],
            ]);

            DB::table('cities')
                ->insert([
                    [
                        'name' => 'New York',
                        'country_id' => 4
                    ],
                    [
                        'name' => 'Miami',
                        'country_id' => 4
                    ],
                    [
                        'name' => 'Buenos Aires',
                        'country_id' => 1
                    ],
                    [
                        'name' => 'Mendoza',
                        'country_id' => 1
                    ],
                    [
                        'name' => 'Rio de Janeiro',
                        'country_id' => 2
                    ],
                    [
                        'name' => 'Sao Paolo',
                        'country_id' => 2
                    ],
                    [
                        'name' => 'Santiago de Chile',
                        'country_id' => 3
                    ],
                    [
                        'name' => 'Uruguay',
                        'country_id' => 5
                    ],
                ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
