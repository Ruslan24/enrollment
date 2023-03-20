<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Faker\Factory as Faker;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        if (!is_null(Enrollment::first())) {
            return;
        }
        $faker = Faker::create();
        $users = User::all();
        $courses = Course::all();
        foreach ($courses as $course) {
            $count = rand(20, 40);
            $enrollments = [];

            for ($i = 0; $i < $count; $i++) {
                $enrollments[] = [
                    'user_id' => $users->random()->id,
                    'course_id' => $course->id,
                    'status' => $faker->numberBetween(1, 2),
                    'created_at' => Carbon::now()
                ];
            }

            Enrollment::insert($enrollments);
        }
    }
}
