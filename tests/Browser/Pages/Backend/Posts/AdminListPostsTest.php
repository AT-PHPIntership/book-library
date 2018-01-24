<?php

namespace Tests\Browser\Pages\Backend\Posts;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;
use App\Model\Book;
use App\Model\Post;
use App\Model\Category;
use App\Model\Donator;
use DB;

class AdminListPostsTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->makeUserLogin();
    }

    /**
     * A Dusk test route to page list posts
     *
     * @return void
     */
    public function testClickRoute()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->clickLink('POSTS')
                    ->assertPathIs('/admin/posts')
                    ->assertSee('List Posts');
        });
    }

    /**
     * A Dusk test show record with table empty.
     *
     * @return void
     */
    public function testListPostsEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts')
                    ->assertSee('List Posts');
            $elements = $browser->elements('#list-posts-table tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * A Dusk test if database limit row perpage
     *
     * @return void
     */
    public function testShowRecord()
    {
        $numberPost = 12;
        $this->makeData($numberPost);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts')
                    ->assertSee('List Posts');
            $elements = $browser->elements('#list-posts-table tbody tr');
            $this->assertCount(config('define.page_length'), $elements);
        });
    }

    /**
     * A Dusk test Pagination
     *
     * @return void
     */
    public function testPagination()
    {
        $numberPost = 12;
        $this->makeUserLogin();
        $this->makeData($numberPost);
        $this->browse(function (Browser $browser) use ($numberPost) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts')
                    ->assertSee('List Posts');
            $elements = $browser->elements('.pagination li');
            $numberPage = count($elements) - 2;
            $this->assertTrue($numberPage == ceil($numberPost / (config('define.page_length'))));
        });
    }

    /**
     * A Dusk test count record last page
     *
     * @return void
     */
    public function testListUsersPagination()
    {
        $numberPost = 12;
        $this->makeUserLogin();
        $this->makeData($numberPost);
        $this->browse(function (Browser $browser) use ($numberPost) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts?page=2')
                    ->assertSee('List Posts')
                    ->assertQueryStringHas('page', 2);
            $elements = $browser->elements('#list-posts-table tbody tr');
            $this->assertCount($numberPost % (config('define.page_length')), $elements); 
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

        factory(Category::class)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $userIds = DB::table('users')->pluck('id')->toArray();
        
        $donator = factory(Donator::class)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i = 0; $i < $row; $i++) {
            factory(Post::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }
    }

    /**
     * Make user to login
     *
     * @return void
     */
    public function makeUserLogin()
    {
        factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }
}
