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
        $qrCode = DB::table('books')->pluck('QRcode')->toArray();
        $faker = Faker::create();
        factory(App\Model\QrCode::class, 16)->create([
            'QRcode' => $faker->randomElement($qrCode),
        ]);
        Model::reguard();
    }
}
