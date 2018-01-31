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
        $this->makeData();
    }

    /**
     * Test display confirm delete post popup
     *
     * @return void
     */
    public function testClickButtonDelelePost()
    {  
        $post = Post::first();
        
        $this->browse(function (Browser $browser) use($post) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts/' . $post->id)
                    ->assertSee('Detail Post')
                    ->click('button.btn-delete-post')
                    ->pause(1000)
                    ->assertSee('Confirm Delete !');
        });
    }

    /**
     * Test click button Close in modal delete post confimation
     *
     * @return void
     */
    public function testClickButtonCloseConfirmDelete()
    {  
        $post = Post::first();
        
        $this->browse(function (Browser $browser) use($post) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts/' . $post->id)
                    ->click('button.btn-delete-post')
                    ->pause(1000)
                    ->assertSee('Confirm Delete !')
                    ->press('Close')
                    ->pause(1000)
                    ->assertDontSee('Confirm Delete !');
        });
    }

    /**
     * Test click button Ok and delete post success
     *
     * @return void
     */
    public function testDeletePostSuccess()
    {  
        $post = Post::first();
        
        $this->browse(function (Browser $browser) use($post) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts/' . $post->id)
                    ->click('button.btn-delete-post')
                    ->pause(1000)
                    ->assertSee('Confirm Delete !')
                    ->press('OK')
                    ->assertSee('Delete success !')
                    ->visit('/admin/posts');
        });
    }

    /**
     * Make data to test
     *
     * @return void
     */
    public function makeData()
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

        factory(Post::class)->create([
            'user_id' => $faker->randomElement($userIds),
            'book_id' => $faker->randomElement($bookIds),
        ]);
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
