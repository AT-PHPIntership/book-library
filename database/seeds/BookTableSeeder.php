<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $categoryId = DB::table('category')->pluck('id')->toArray();
        $donatorId = DB::table('donator')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'donator_id' => $faker->randomElement($donatorId)
            ]);
        }
        Model::reguard();
    }
}
