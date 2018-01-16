<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        $postId = DB::table('posts')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 9; $i++) {
            factory(App\Model\Comment::class, 1)->create([
                'post_id' => $faker->randomElement($postId),
                'user_id' => $faker->randomElement($userId),
            ]);
            factory(App\Model\Comment::class, 1)->create([
                'post_id' => $faker->randomElement($postId),
                'user_id' => $faker->randomElement($userId),
                'parent_id' => rand(1,9)
            ]);
        }
        Model::reguard();
    }
}
