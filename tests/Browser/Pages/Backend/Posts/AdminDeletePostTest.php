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

class AdminDeletePostTest extends DuskTestCase
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
                    ->resize(1200, 1600)
                    ->assertSee('Detail Post')
                    ->click('button.fa-trash-o')
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
                    ->resize(1200, 1600)
                    ->click('button.fa-trash-o')
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
                    ->resize(1200, 1600)
                    ->click('button.fa-trash-o')
                    ->pause(1000)
                    ->assertSee('Confirm Delete !')
                    ->press('OK')
                    ->assertSee('Delete success !')
                    ->visit('/admin/posts');
        });
    }

    /**
     * Test click button Ok and delete post fail
     *
     * @return void
     */
    public function testDeletePostFail()
    {  
        $post = Post::first();
        
        $this->browse(function (Browser $browser) use($post) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/posts/' . $post->id)
                    ->resize(1200, 1600);
            $post->delete();
            $browser->click('button.fa-trash-o')
                    ->pause(1000)
                    ->assertSee('Confirm Delete !')
                    ->press('OK')
                    ->assertDontSee('Delete success !');
        });
    }

    /**
     * Test delete post with DELETE method
     *
     * @return void
     */
    public function testWithDeleteMethod() {
        $post = Post::first();

        $this->withoutMiddleware();
        $response = $this->call('DELETE', '/admin/posts/' . $post->id);
        $this->assertDatabaseMissing('posts', ['deleted_at' => null, 'id' => $post->id]);
    }

    /**
     * Test delete post with GET method
     *
     * @return void
     */
    public function testWithGetMethod() {
        $post = Post::first();

        $this->withoutMiddleware();
        $response = $this->call('GET', '/admin/posts/' . $post->id);
        $this->assertDatabaseHas('posts', ['deleted_at' => null, 'id' => $post->id]);
    }

    /**
     * Test delete post with POST method
     *
     * @return void
     */
    public function testWithPostMethod() {
        $post = Post::first();

        $this->withoutMiddleware();
        $response = $this->call('POST', '/admin/posts/' . $post->id);
        $this->assertDatabaseHas('posts', ['deleted_at' => null, 'id' => $post->id]);
    }

    /**
     * Test delete post with PUT method
     *
     * @return void
     */
    public function testWithPutMethod() {
        $post = Post::first();

        $this->withoutMiddleware();
        $response = $this->call('PUT', '/admin/posts/' . $post->id);
        $this->assertDatabaseHas('posts', ['deleted_at' => null, 'id' => $post->id]);
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
