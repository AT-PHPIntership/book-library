<?php

namespace Tests\Browser\BackEnd;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminEditBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 10)->create([
            'user_id' => $faker->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, 1)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testEditbutton()
//    {
//        $this->makeData();
//        $this->browse(function (Browser $browser) {
//            $browser->visit('/admin/books')
//                ->resize(1200, 900)
//                ->assertSee('LIST OF BOOK')
//                ->click('#table-content tbody tr td .btn-edit-1')
//                ->assertPathIs('/admin/books/1/edit')
//                ->assertSee('Edit Book');
//
//        });
//    }
}