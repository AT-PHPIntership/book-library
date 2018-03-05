<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use App\Model\Borrowing;
use App\Model\QrCode;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SearchBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();

        factory(Category::class, 5)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        factory(User::class, 5)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        factory(Donator::class, 5)->create([
            'user_id' => $faker->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        for ($i = 0; $i <= $row; $i++)
        {
            factory(Book::class,1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds),
                'name' => $faker->sentence(rand(2,5)),
                'author' => $faker->name,
            ]);
        }

        factory(Book::class, 1)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
            'name' => 'JavaScript and Jquey',
            'author' => 'Murach’s',
        ]);

        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i = 0; $i <= $row; $i++)
        {
            $borrowing = factory(Borrowing::class, 1)->create([
                'book_id' =>  $faker->randomElement($bookIds),
                'user_id' =>  $faker->randomElement($userIds),
            ]);
        }
        $bookNumber = DB::table('books')->count();
        for ($bookID = 1; $bookID <= $bookNumber; $bookID++) {
            factory(QrCode::class)->create([
                'book_id' => $bookID,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }
    }

    /**
    * A User with role 1 test example.
    *
    * @return void
    */
    public function userLogin()
    {
        factory(User::class, 1)->create([
           'team'          => 'PHP',
           'role'          => 1,
        ]);
    }

    /**
     * A Dusk test looking input search null with select all
     *
     * @return void
     */
    public function testSeeInputNullSelectAll()
    {
        $this->userLogin();
        $this->makeData(6);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('search', '')
                    ->select('choose', 'Name - Author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('.btn.btn-info')
                    ->visit('/admin/books?search=&choose=all')
                    ->assertQueryStringHas('search', '')
                    ->assertQueryStringHas('choose', 'all');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(8, $elements);
        });
    }

    /**
     * A Dusk test looking input search null with select name
     *
     * @return void
     */
    public function testSeeInputNullSelectName()
    {
        $this->userLogin();
        $this->makeData(6);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('search', '')
                    ->select('choose', 'Name')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('.btn.btn-info')
                    ->visit('/admin/books?search=&choose=name')
                    ->assertQueryStringHas('search', '')
                    ->assertQueryStringHas('choose', 'name');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(8, $elements);
        });
    }

    /**
     * A Dusk test looking input search null with select author
     *
     * @return void
     */
    public function testSeeInputNullSelectAuthor()
    {
        $this->userLogin();
        $this->makeData(6);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('search', '')
                    ->select('choose', 'Author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('.btn.btn-info')
                    ->visit('/admin/books?search=&choose=author')
                    ->assertQueryStringHas('search', '')
                    ->assertQueryStringHas('choose', 'author');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(8, $elements);
        });
    }

    /**
     * A Dusk test when input search is name and select all
     *
     * @return void
     */
    public function testSearchNameSelectAll()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'JavaScript')
                    ->select('choose', 'Name - Author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=JavaScript&choose=all')
                    ->assertQueryStringHas('search', 'JavaScript')
                    ->assertQueryStringHas('choose', 'all')
                    ->assertSee('JavaScript');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search is author and select all
     *
     * @return void
     */
    public function testSearchAuthorSelectAll()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'Murach')
                    ->select('choose', 'Name - Author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=Murach&choose=all')
                    ->assertQueryStringHas('search', 'Murach')
                    ->assertQueryStringHas('choose', 'all')
                    ->assertSee('Murach');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search name and select name
     *
     * @return void
     */
    public function testSearchNameSelectName()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'JavaScript')
                    ->select('choose', 'Name')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=JavaScript&choose=name')
                    ->assertQueryStringHas('search', 'JavaScript')
                    ->assertQueryStringHas('choose', 'name')
                    ->assertSee('JavaScript');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author and select author
     *
     * @return void
     */
    public function testSearchAuthorSelectAuthor()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'Murach')
                    ->select('choose', 'author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=Murach&choose=author')
                    ->assertQueryStringHas('search', 'Murach')
                    ->assertQueryStringHas('choose', 'author')
                    ->assertSee('Murach');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author or name incorrect with select all
     *
     * @return void
     */
    public function testSearchNameAuthorIncorrectSelectAll()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'hello')
                    ->select('choose', 'author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=hello&choose=all')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search name incorrect with select name
     *
     * @return void
     */
    public function testSearchNameIncorrectSelectName()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'hello')
                    ->select('choose', 'name')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=hello&choose=name')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author incorrect with select author
     *
     * @return void
     */
    public function testSearchAuthorIncorrectSelectAuthor()
    {
        $this->userLogin();
        $this->makeData(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('search', 'hello')
                    ->select('choose', 'author')
                    ->assertVisible('.btn.btn-info .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?search=hello&choose=author')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }
}
