<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
        $bookId = DB::table('books')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employee_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Borrow::class, 1)->create([
                'book_id' => $faker->randomElement($bookId),
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        Model::reguard();
    }
}
