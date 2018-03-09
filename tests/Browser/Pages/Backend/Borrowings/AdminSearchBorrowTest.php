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
     * test exist search box in list borrow
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
     * test search with empty data in input search and filter is all
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
     * test search with empty data in input search and filter is books
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
     * test search with empty data in input search and filter is users
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
     * test search have data in input search and filter is all but no results returned
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
     * test search have data in input search and filter is users but no results returned
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
     * test search have data in input search and filter is books but no results returned
     *
     * @return void
     */
    public function testSearchDataFilterBooksButNotResultReturned()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'Javascript')
                ->select('choose', 'books')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(0, $elements);    
        });
    }

    /**
     * test search have data in input search and filter is all have results returned
     *
     * @return void
     */
    public function testSearchDataFilterAllHaveResultReturned()
    {
        $this->makeDataForSpecialCases();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'HTML & CSS')
                ->select('choose', 'all')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * test search have data in input search and filter is books have results returned
     *
     * @return void
     */
    public function testSearchDataFilterBooksHaveResultReturned()
    {
        $this->makeDataForSpecialCases();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/borrowings')
                ->type('search', 'HTML & CSS')
                ->select('choose', 'books')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * test search have data in input search and filter is users have results returned
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
                ->type('search', 'hayantt')
                ->select('choose', 'users')
                ->click('#search-borrow')
                ->pause(2000);
            $elements = $browser->elements('#table-borrowings tbody tr');
            $this->assertCount(3, $elements);    
        });
    }

    /**
     * make data to unit test search borrow
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();

        factory(Category::class)->create();

        $users = factory(User::class, 5)->create();
        $userIds = $users->pluck('id')->toArray();
        
        factory(Donator::class)->create();

        $books = factory(Book::class, 5)->create([
            'category_id' => 1,
            'donator_id'  => 1,
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
     * make data to unit test for special cases
     *
     * @return void
     */
    public function makeDataForSpecialCases()
    {
        $faker = Faker::create();
        factory(User::class)->create([
            'id' => '161',
            'name' => 'hayantt'
        ]);
        factory(Book::class)->create([
            'id'             => '2018',
            'category_id'    => 1,
            'donator_id'     => 1,
            'name'           => 'HTML & CSS',
            'author'         => $faker->name
        ]);
        $borrowing = factory(Borrowing::class, 3)->create([
            'book_id' =>  2018,
            'user_id' =>  161
        ]);
    }
}
