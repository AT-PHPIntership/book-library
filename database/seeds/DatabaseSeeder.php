<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(DonatorsTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(BorrowingsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
    }
}
