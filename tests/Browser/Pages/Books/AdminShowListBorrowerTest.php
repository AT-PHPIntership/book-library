<?php

namespace Tests\Browser\tests\Browser\Pages\BackEnd\Books;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminShowListBorrowingsTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * Create user with role "Admin".
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create(['role' => User::ROLE_ADMIN]);
    }

    /**
     * Make list database
     *
     * @param Int $rows Number of borrowing.
     *
     * @return void
     */
    public function makeListBorrowing($rows)
    {
        $this->makeListOfBook(10);
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i=0; $i<= $rows; $i++){
            factory(Borrowing::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }
    }

    /**
     * Check page with showing only 10 rows on page 1
     *
     * @return void
     */
    public function testShowListBorrower()
    {
        $this->makeListBorrowing(9);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->assertTitle('Admin | LIST OF BORROWINGS');
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
        $this->makeListBorrowing(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->click('.pagination li:nth-child(3) a');
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
