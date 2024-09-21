<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = \Faker\Factory::create('id_ID');
        for($i = 0 ; $i<10; $i++) {
            Post::create([
                'author' => $faker->name,
                'title' => $faker->sentence,
                'slug' => $faker->sentence,
                'thumbnail' => '',
                'content' => $faker->sentence
            ]);
        }
    }
}
