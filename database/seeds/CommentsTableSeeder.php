<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $userId = DB::table('users')->pluck('employee_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Comment::class, 1)->create(['user_id' => $faker->randomElement($userId)]);            
        }
        Model::reguard();
    }
}
