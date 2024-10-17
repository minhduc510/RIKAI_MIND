<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('posts')->insert([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraph(10),
                'published_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
