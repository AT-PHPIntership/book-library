<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class LikesAndSharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $postId = DB::table('posts')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employee_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\LikeAndShare::class, 1)->create([
                'post_id' => $faker->randomElement($postId),
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        Model::reguard();
    }
}
