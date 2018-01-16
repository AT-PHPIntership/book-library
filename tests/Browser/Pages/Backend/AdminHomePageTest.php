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

    // /**
    //  * A Dusk test route home page.
    //  *
    //  * @return void
    //  */
    // public function testRoute()
    // {
    //     $this->userLogin(1);
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/admin')
    //                 ->clickLink('HOME PAGE')
    //                 ->assertPathIs('/admin')
    //                 ->assertSee('Home Page')
    //                 ->assertSee('Categories')
    //                 ->assertSee('Books')
    //                 ->assertSee('Posts')
    //                 ->assertSee('Users');
    //     });
    // }

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
