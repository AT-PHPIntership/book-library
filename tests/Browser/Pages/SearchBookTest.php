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
    public function makeData()
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

        for ($i = 0; $i <= 16; $i++)
        {
            factory(Book::class, 1)->create([
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
        for ($i = 0; $i <= 16; $i++)
        {
            $borrowing = factory(Borrowing::class, 1)->create([
                'book_id' =>  $faker->randomElement($bookIds),
                'user_id' =>  $faker->randomElement($userIds),
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
           'employee_code' => 'ATI0285',
           'name'          => 'Luan Le T.',
           'email'         => 'luan.le@asiantech.vn',
           'team'          => 'PHP',
           'role'          => 1,
        ]);
    }

    /**
     * A Dusk test looking input search name, author and button search
     *
     * @return void
     */
    public function testSeeInputSearch()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('name', '')
                    ->assertInputValue('author', '')
                    ->assertVisible('.btn.btn-default .fa.fa-search');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(10, $elements);
        });
    }

    /**
     * A Dusk test when input search name and author null
     *
     * @return void
     */
    public function testSearchInputNull()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('name', '')
                    ->assertInputValue('author', '')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->assertQueryStringHas('name', '')
                    ->assertQueryStringHas('author', '');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(10, $elements);
        });
    }

    /**
     * A Dusk test when input search name and input author null
     *
     * @return void
     */
    public function testSearchNameHasValue()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('name', 'JavaScript')
                    ->assertInputValue('author', '')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=JavaScript&author=')
                    ->assertSee('JavaScript');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author and input name null
     *
     * @return void
     */
    public function testSearchAuthorHasValue()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->assertInputValue('name', '')
                    ->type('author', 'Murach')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=&author=Murach')
                    ->assertSee('Murach');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author and input name
     *
     * @return void
     */
    public function testSearchNameAuthorHasValue()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('name', 'JavaScript')
                    ->type('author', 'Murach')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=JavaScript&author=Murach')
                    ->assertSee('JavaScript')
                    ->assertSee('Murach');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test when input search author incorrect and input name incorrect not found
     *
     * @return void
     */
    public function testSearchNameAuthorHasValueIncorrect()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('name', 'Mysql')
                    ->type('author', 'Neymar')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=Mysql&author=Neymar')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
        });
    }

    /**
     * A Dusk test when input search name correct and input author incorrect not found
     *
     * @return void
     */
    public function testSearchNameCorrectAndAuthorIncorrect()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('name', 'JavaScript')
                    ->type('author', 'Neymar')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=JavaScript&author=Neymar')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
        });
    }

    /**
     * A Dusk test when input search name incorrect and input author correct not found
     *
     * @return void
     */
    public function testSearchNameInCorrectAndAuthorCorrect()
    {
        $this->userLogin();
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('LIST OF BOOK')
                    ->type('name', 'Mysql')
                    ->type('author', 'Murach')
                    ->assertVisible('.btn.btn-default .fa.fa-search')
                    ->click('#submit')
                    ->visit('/admin/books?name=Mysql&author=Murach')
                    ->assertSee('Sorry, Not be found.')
                    ->assertSee('ComeBack');
        });
    }
}
