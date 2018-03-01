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
        for ($i = 1; $i <= 16; $i++) {
            factory(App\Model\QrCode::class, 1)->create([
                'book_id' => $i,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }
        Model::reguard();
    }
}
