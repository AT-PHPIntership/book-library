<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $bookId = DB::table('books')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        $posts = DB::table('posts')->get();
        foreach ($posts as $value) {
            factory(App\Model\Rating::class, 1)->create([
                'book_id' => $value->book_id,
                'user_id' => $value->user_id,
                'rating'  => rand(1,5),
            ]);
        }
        Model::reguard();
    }
}
