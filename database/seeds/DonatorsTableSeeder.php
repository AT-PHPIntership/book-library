<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DonatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        factory(App\Model\Donator::class, 10)->create([
            'user_id' => $faker->randomElement($userId)
        ]);
        factory(App\Model\Donator::class, 10)->create([
            'employee_code' => 'AT-' . $faker->unique()->randomNumber(3),
            'name'          => $faker->name,
            'email'         => $faker->safeEmail,
        ]);
        Model::reguard();
    }
}
