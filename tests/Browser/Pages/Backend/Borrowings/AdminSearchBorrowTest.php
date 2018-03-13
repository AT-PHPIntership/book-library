<?php

namespace Tests\Browser\Pages\Backend\Borrowings;

use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Donator;
use Tests\DuskTestCase;
use App\Model\Category;
use App\Model\Borrowing;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;

class AdminSearchBorrowTest extends BaseTestUser
{
    use DatabaseMigrations;

    const NUMBER_BORROWS = 6;

    private $adminUserToLogin;
    private $category;
    private $donator;
    private $specialUser;
    private $specialBook;

    /**
    * Override function setUp()
    *
    * @return void
    */
    public function setUp()
    {
        parent::setUp();
        $this->adminUserToLogin = $this->makeAdminUserToLogin();
        $this->makeData(self::NUMBER_BORROWS);
    }

    /**
     * Test exist search box in list borrow
     *
     * @return void
     */
    public function testLayoutSearchInListBorrow()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('admin/borrowings')
                ->assertSee('List Borrowers')
                ->assertVisible('#frm-search-borrow')
                ->assertVisible('input[name=search]')
                ->assertVisible('select[name=choose]')
                ->assertVisible('#search-borrow')
                ->assertVisible('.fa-search');
        });
    }

    /**
     * Test search with empty data in input search and filter is all
     *
     * @return void
     */
    public function testSearchEmptyInputFilterAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->assertInputValue('search', '')
                ->select('choose', 'all')
                ->click('#search-borrow')
                ->visit('/admin/borrowings?search=&choose=all')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('choose', 'all');
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(self::NUMBER_BORROWS, $elements);    
        });
    }

    /**
     * Test search with empty data in input search and filter is books
     *
     * @return void
     */
    public function testSearchEmptyInputFilterBooks()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->assertInputValue('search', '')
                ->select('choose', 'books')
                ->click('#search-borrow')
                ->visit('/admin/borrowings?search=&choose=books')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('choose', 'books');
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(self::NUMBER_BORROWS, $elements);    
        });
    }

    /**
     * Test search with empty data in input search and filter is users
     *
     * @return void
     */
    public function testSearchEmptyInputFilterUsers()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->assertInputValue('search', '')
                ->select('choose', 'users')
                ->click('#search-borrow')
                ->visit('/admin/borrowings?search=&choose=users')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('choose', 'users');
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(self::NUMBER_BORROWS, $elements);    
        });
    }

    /**
     * Test search have data in input search and filter is all but no results returned
     *
     * @return void
     */
    public function testSearchDataFilterAllButNotResultReturned()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'Vo Van Nghia')
                ->select('choose', 'all')
                ->click('#search-borrow');
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(0, $elements);    
        });
    }

    /**
     * Test search have data in input search and filter is users but no results returned
     *
     * @return void
     */
    public function testSearchDataFilterUsersButNotResultReturned()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'Vo Van Nghia')
                ->select('choose', 'users')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     * Test search have data in input search and filter is books but no results returned
     *
     * @return void
     */
    public function testSearchDataFilterBooksButNotResultReturned()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'Vo Van Nghia')
                ->select('choose', 'books')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(0, $elements);    
        });
    }

    /**
     * Test search have data in input search and filter is all have results returned
     *
     * @return void
     */
    public function testSearchDataFilterAllHaveResultReturned()
    {
        $this->makeDataForSpecialCases();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', $this->specialBook->name)
                ->select('choose', 'all')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * Test search have data in input search and filter is books have results returned
     *
     * @return void
     */
    public function testSearchDataFilterBooksHaveResultReturned()
    {
        $this->makeDataForSpecialCases();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', $this->specialBook->name)
                ->select('choose', 'books')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * Test search have data in input search and filter is users have results returned
     *
     * @return void
     */
    public function testSearchDataFilterUsersHaveResultReturned()
    {
        $this->makeDataForSpecialCases();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->resize(1600, 2000)
                ->type('search', $this->specialUser->name)
                ->select('choose', 'users')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * Make data to unit test search borrow
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $this->category = factory(Category::class)->create();
        $users = factory(User::class, 5)->create();
        $userIds = $users->pluck('id')->toArray();
        $this->donator = factory(Donator::class)->create();
        $books = factory(Book::class, 5)->create([
            'category_id' => $this->category->id,
            'donator_id'  => $this->donator->id,
            'name'        => $faker->name,
            'author'      => $faker->name
        ]);
        $bookIds = $books->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++)
        {
            $borrowing = factory(Borrowing::class)->create([
                'book_id' =>  $faker->randomElement($bookIds),
                'user_id' =>  $faker->randomElement($userIds)
            ]);
        }
    }
    
    /**
     * Make data to unit test for special cases
     *
     * @return void
     */
    public function makeDataForSpecialCases()
    {
        $faker = Faker::create();
        $this->specialUser = factory(User::class)->create([
            'name' => $faker->name
        ]);
        $this->specialBook = factory(Book::class)->create([
            'category_id'    => $this->category->id,
            'donator_id'     => $this->donator->id,
            'name'           => $faker->name,
            'author'         => $this->specialUser->name
        ]);
        $borrowing = factory(Borrowing::class, 3)->create([
            'book_id' =>  $this->specialBook->id,
            'user_id' =>  $this->specialUser->id
        ]);
    }
}
