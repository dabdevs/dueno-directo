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
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
