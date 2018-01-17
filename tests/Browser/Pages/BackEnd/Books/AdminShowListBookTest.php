<?php

namespace Tests\Browser\tests\Browser\Pages\BackEnd\Books;

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

class AdminShowListBookTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeListOfBook($rows)
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
            factory(Book::class, $rows)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
    }

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeUser(){
        $faker = Faker::create();
        factory(User::class, 1)->create([
            'role' => 1
        ]);
    }

    /**
     * Check page with showing only 10 rows on page 1
     *
     * @return void
     */
    public function testShowListBook()
    {
        $this->makeUser(1);
        $this->makeListOfBook(10);
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/books/')
                ->resize(1200, 900)
                ->assertTitle('Admin | List of book')
                ->assertSee('LIST OF BOOK')
                ->screenshot('sample-screenshot');
        $elements = $browser->elements('#table-book tbody tr');
        $this->assertCount(10, $elements);
        $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * Test page 2 showing only 5 rows.
     *
     * @return void
     */
    public function testShowPageList()
    {
        $this->makeUser(1);
        $this->makeListOfBook(15);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/books')
                            ->resize(1200, 900)
                            ->click('.pagination li:nth-child(3) a')
                            ->screenshot('sample-screenshot');

            $elements = $page->elements('#table-book tbody tr');
            $this->assertCount(5, $elements);
            $browser->assertQueryStringHas('page', 2);
            $this->assertNotNull($browser->element('.pagination'));
        });
    }

    /**
     * Test page empty.
     *
     * @return void
     */
    public function testEmptyPage()
    {
        $this->makeUser(1);
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/books')
                ->resize(1200, 900)
                ->assertSee('Sorry, Not be found.')
                ->assertTitle('Admin | List of book');
        $elements = $browser->elements('#table-book tbody tr');
        $this->assertNull($browser->element('.pagination'));
        });
    }
}