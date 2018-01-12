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
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        factory(App\Model\QrCode::class, 16)->create([
            'book_id' => $faker->randomElement($bookId),
            'code_id' => $faker->unique()->randomNumber(4),
            'prefix' => 'BAT-'
        ]);
        Model::reguard();
    }
}
