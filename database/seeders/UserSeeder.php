<?php

namespace Database\Seeders;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
        foreach (range(1,20) as $index){
            DB::table('users')->insert([
                'name'=>$faker->name,
                'email' =>$faker->email,
                'password' =>$faker->password,
            ]);
        }

    }
}
