<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class BorrowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $bookId = App\Model\Book::all('id')->pluck('id')->toArray();
        $userId = app\Model\User::all('id')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Borrow::class, 1)->create(['book_id' => $faker->randomElement('$bookId')]);
            factory(App\Model\Borrow::class, 1)->create(['user_id' => $faker->randomElement('$userId')]);            
        }
        Model::reguard();
    }
}
