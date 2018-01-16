<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 25; $i++) {
            factory(App\Model\Favorite::class, 1)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        Model::reguard();
    }
}
