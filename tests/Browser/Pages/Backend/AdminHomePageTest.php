<?php

namespace Tests\Browser\Pages\Backend;

use App\Model\User;
use App\Model\Book;
use App\Model\Post;
use App\Model\Donator;
use Tests\DuskTestCase;
use App\Model\Category;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminHomePageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test route home page.
     *
     * @return void
     */
    public function testRoute()
    {
        $this->userLogin(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->clickLink('HOME PAGE')
                    ->assertPathIs('/admin')
                    ->assertSee('Home Page')
                    ->assertSee('Categories')
                    ->assertSee('Books')
                    ->assertSee('Posts')
                    ->assertSee('Users');
        });
    }

    /**
     * A Dusk test value data.
     *
     * @return void
     */
    public function testValueData()
    {
        $this->userLogin(1);
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->assertSee('Home Page')
                    ->assertSee('Categories')
                    ->assertSee('Books')
                    ->assertSee('Posts')
                    ->assertSee('Users')
                    ->screenshot('value')
                    ->assertSeeIn('.small-box .inner h3', '10');
        });
    }

    /**
     * A Dusk test redirect to User donator.
     *
     * @dataProvider caseTestRedirectPage
     * 
     * @return void
     */
    public function testRedirecttoUserFilter($id, $link, $title, $filter, $limit, $table, $number)
    {
        $this->userLogin(1);
        $this->makeData();
        $this->browse(function (Browser $browser) use ($id, $link, $title, $filter, $limit, $table, $number) {
            $browser->loginAs(User::first())
                    ->visit('/admin')
                    ->assertSee('Home Page')
                    ->resize(800, 1600)
                    ->click($id.' .small-box-footer')
                    ->assertPathIs('/admin/'.$link)
                    ->assertSee($title)
                    ->assertQueryStringHas('filter', $filter)
                    ->assertQueryStringHas('limit', $limit);
            $elements = $browser->elements($table.' tbody tr');
            $this->assertCount($number, $elements);
        });
    }

    /**
     * Case test fot test redirect page
     *
     * @return array
     */
    public function caseTestRedirectPage()
    {
        return [
            ['#donator', 'users',  'List Users', 'donator', 5, '#example2', 5],
            ['#borrowed', 'books', 'LIST OF BOOK', 'borrowed', 10, '#table-book', 10],
        ];
    }

    /**
     * Make data user login.
     *
     * @return void
     */
    public function userLogin()
    {   
        factory(User::class, 1)->create([
            'role' => 1
        ]);
        
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
        factory(Category::class, 10)->create();
        $categoryId = Category::all('id')->pluck('id')->toArray();
        factory(Donator::class, 5)->create();
        $donatorId = Donator::all('id')->pluck('id')->toArray();
        factory(User::class, 9)->create();
        $userId = User::all('id')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'donator_id' => $faker->randomElement($donatorId)
            ]);
        }
        $bookId = Book::all('id')->pluck('id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            factory(Post::class, 1)->create([
                'user_id' => $faker->randomElement($userId),
                'book_id' => $faker->randomElement($bookId)
            ]);
        }
    }
}
