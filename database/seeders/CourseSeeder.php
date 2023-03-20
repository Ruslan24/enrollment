<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use Faker\Factory as Faker;

class CourseSeeder extends Seeder
{
    public function run()
    {
        if (!is_null(Course::first())) {
            return;
        }
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            Course::create([
                'title' => $faker->sentence(),
            ]);
        }
    }
}
