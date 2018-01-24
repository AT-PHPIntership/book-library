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
     * Make list database
     *
     * @return void
     */
    public function makeList($rows)
    {
        $faker = Faker::create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        factory(Category::class, 10)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class, 10)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);

        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i=0; $i<= $rows; $i++){
            factory(Borrowing::class, 1)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }

    }

    /**
     * Make user database
     *
     * @return void
     */
    public function makeUser(){
        factory(User::class)->create([
            'role' => 1
        ]);
    }

    /**
     * Check page with showing only 10 rows on page 1
     *
     * @return void
     */
    public function testShowListBorrower()
    {
        $this->makeUser();
        $this->makeList(9);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->assertTitle('Admin | LIST OF BORROWINGS')
                ->screenshot('sample-screenshot');
            $elements = $browser->elements('#table-borrowings tbody tr');
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
        $this->makeUser();
        $this->makeList(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->click('.pagination li:nth-child(3) a')
                ->screenshot('sample-screenshot');

            $elements = $page->elements('#table-borrowings tbody tr');
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
        $this->makeUser();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->assertTitle('Admin | LIST OF BORROWINGS');
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }
}
