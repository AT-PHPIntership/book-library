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
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminShowListBookTest extends BaseTestBook
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
     * Check page with showing only 10 rows on page 1
     *
     * @return void
     */
    public function testShowListBook()
    {
        $this->makeListOfBook(10);
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/books/')
                ->resize(900, 1600)
                ->assertTitle('Admin | LIST OF BOOK');
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
        $this->makeListOfBook(15);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/books')
                            ->resize(900, 1600)
                            ->click('.pagination li:nth-child(3) a');
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
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/books')
                ->resize(900, 1600)
                ->assertSee('Sorry, Not be found.')
                ->assertTitle('Admin | LIST OF BOOK');
        $elements = $browser->elements('#table-book tbody tr');
        $this->assertNull($browser->element('.pagination'));
        });
    }
}
