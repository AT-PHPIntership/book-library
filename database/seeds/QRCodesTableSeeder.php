<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class QRCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $bookNumber = DB::table('books')->count();
        $faker = Faker::create();
        for ($bookID = 1; $bookID <= $bookNumber; $bookID++) {
            factory(App\Model\QrCode::class)->create([
                'book_id' => $bookID,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }
        Model::reguard();
    }
}
