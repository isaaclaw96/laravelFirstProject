<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = faker::create();
        foreach (range(1,5) as $index){
            DB::table('jobs')->insert([
                'title'=>$faker->jobTitle,
                'description' =>$faker->sentence($nbWords = 5, $variableNbWords = true),
                'min_salary' =>$faker->numberBetween($min = 1000, $max = 9000),
                'max_salary'=>$faker->numberBetween($min = 1000, $max = 9000),
            ]);
        }
    }
}
