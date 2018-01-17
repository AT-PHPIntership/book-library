<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;
use App\Model\Category;
use App\Model\Donator;
use App\Model\Book;
use App\Model\Borrowing;
use DB;

class AdminListUsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test route to page list users.
     *
     * @return void
     */
    public function testClickRoute()
    {
        $this->makeUserLogin();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->clickLink('USERS')
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users');
        });
    }
    
    /**
     * A Dusk test if database limit row perpage
     *
     * @return void
     */
    public function testShowRecord()
    {
        $this->makeUserLogin();
        $this->makeData(12);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users')
                    ->assertSee('List Users');
            $elements = $browser->elements('#example2 tbody tr');
            $this->assertCount(10, $elements);
        });
    }

    /**
     * A Dusk test Pagination
     *
     * @return void
     */
    public function testPagination()
    {
        $this->makeUserLogin();
        $this->makeData(12);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users')
                    ->assertSee('List Users');
            $elements = $browser->elements('.pagination li');
            $number_page = count($elements) - 2;
            $this->assertTrue($number_page == 2);
        });
    }

    /**
     * A Dusk test count record last page
     *
     * @return void
     */
    public function testListUsersPagination()
    {
        $this->makeUserLogin();
        $this->makeData(11);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users?page=2')
                    ->assertSee('List Users')
                    ->assertQueryStringHas('page', 2);
            $elements = $browser->elements('#example2 tbody tr');
            $this->assertCount(2, $elements); 
        });
    }

    /**
     * Make data to test
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();

        factory(Category::class, 2)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        factory(User::class, $row)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        factory(Donator::class, 2)->create([
            'user_id' => $faker->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class, 2)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        $bookIds = DB::table('books')->pluck('id')->toArray();

        $borrowings = factory(Borrowing::class, 10)->create([
            'book_id' => $faker->randomElement($bookIds),
            'user_id' => $faker->randomElement($userIds),
        ]);
    }
    public function makeUserLogin()
    {
        factory(User::class, 1)->create([
            'role' => 1
        ]);
    }
}
