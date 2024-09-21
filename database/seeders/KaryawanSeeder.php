<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = \Faker\Factory::create('id_ID');
        for($i = 0 ; $i<10; $i++) {
            Karyawan::create([
                'name' => $faker->name,
                'avatar' => '',
                'job' => $faker->sentence,
            ]);
        }
    }
}
