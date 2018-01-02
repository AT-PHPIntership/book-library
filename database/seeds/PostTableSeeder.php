<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $bookId = DB::table('book')->pluck('id')->toArray();
        $userId = DB::table('user')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Post::class, 1)->create([
                'book_id' => $faker->randomElement($bookId),
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        Model::reguard();
    }
}
