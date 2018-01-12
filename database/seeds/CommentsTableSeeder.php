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
        factory(App\Model\Comment::class, 9)->create([
            'post_id' => $faker->randomElement($postId),
            'user_id' => $faker->randomElement($userId),
        ]);
        factory(App\Model\Comment::class, 7)->create([
            'post_id' => $faker->randomElement($postId),
            'user_id' => $faker->randomElement($userId),
            'parent_id' => rand(1,9)
        ]);
        Model::reguard();
    }
}
