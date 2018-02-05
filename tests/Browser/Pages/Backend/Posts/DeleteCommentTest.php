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
use App\Model\Comment;
use App\Model\Rating;
use DB;

class DeleteCommentTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $user;
    
    /**
    * Override function setUp()
    *
    * @return void
    */
    public function setUp()
    {
        parent::setUp();
        $this->user = $this->makeUserLogin();
        $this->makeData();
    }

    /**
    * Looking button delete comment in post page
    *
    * @return void
    */
    public function testSeeButtonDeleteComment()
    {
        $post = Post::first();
        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success')
                    ->click('.btn.btn-success')
                    ->visit('/admin/posts/' . $post->id)
                    ->assertPathIs('/admin/posts/' . $post->id)
                    ->assertVisible('.glyphicon.glyphicon-remove.text-warning');
        });
    }

    /**
    * Click with post id not exists
    *
    * @return void
    */
    public function testPostIdNotExists()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->visit('/admin/posts/100')
                    ->assertDontSee('Detail Post')
                    ->pause(1000)
                    ->assertPathIs('/admin/posts')
                    ->assertSee('List Posts');
        });
    }

    /**
    * Looking model delete comment when click on button delete in post page
    *
    * @return void
    */
    public function testSeeModelDeleteComment()
    {
        $post = Post::first();
        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts/' . $post->id)
                    ->assertPathIs('/admin/posts/' . $post->id)
                    ->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->assertSee('Confirm Delete')
                    ->assertSee('OK')
                    ->assertSee('Close');
        });
    }

    /**
    * Process Button Close
    *
    * @return void
    */
    public function testClickButtonClose()
    {
        $post = Post::first();
        $comments = Comment::where('post_id', $post->id)->get();
        $count = count($comments);

        $this->browse(function (Browser $browser) use ($post, $count) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts/' . $post->id)
                    ->assertPathIs('/admin/posts/' . $post->id);
            $this->assertTrue(2 == $count);
            $browser->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->press('Close')
                    ->assertPathIs('/admin/posts/' . $post->id);
            $this->assertTrue(2 == $count);
        });
    }

    /**
    * Process delete parent comment
    *
    * @return void
    */
    public function testClickButtonOkIsParent()
    {
        $post = Post::first();
        $comments = Comment::where('post_id', $post->id)->get();
        $count = count($comments);

        $this->browse(function (Browser $browser) use ($post, $count) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts/' . $post->id)
                    ->assertPathIs('/admin/posts/' . $post->id);
            $this->assertTrue(2 == $count);
            $browser->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->press('OK')
                    ->pause(1000)
                    ->assertSee('Success! Delete Comments');
            $commentLast = Comment::where('post_id', $post->id)->get();
            $this->assertTrue(0 == count($commentLast));
        });
    }

    /**
    * Process delete children comment
    *
    * @return void
    */
    public function testClickButtonOkIsChildren()
    {
        $post = Post::first();
        $comment = Comment::where('post_id', $post->id)->where('parent_id', '!=', null)->first();
        $this->browse(function (Browser $browser) use ($post, $comment) {
            $browser->loginAs($this->user)
                    ->resize(1200, 1600)
                    ->visit('/admin/posts/' . $post->id)
                    ->assertPathIs('/admin/posts/' . $post->id);
            $this->assertTrue(1 == count($comment));
            $browser->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->press('OK')
                    ->pause(1000)
                    ->assertSee('Success! Delete Comments');
            $commentLast = Comment::where('post_id', $post->id)->where('parent_id', '!=', null)->first();
            $this->assertTrue(0 == count($commentLast));
        });
    }

    /**
    * Make data has comment
    *
    * @return void
    */
    public function makeData()
    {
        $faker = Faker::create();

        $category = factory(Category::class)->create();
        $donator = factory(Donator::class)->create([
           'user_id' => $this->user->id
        ]);
        $book = factory(Book::class)->create([
           'category_id' => $category->id,
           'donator_id' => $donator->id,
        ]);

        factory(Post::class)->create([
            'user_id' => $this->user->id,
            'book_id' => $book->id,
        ]);

        $post = Post::first();
            factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
            'parent_id' => null,
        ]);

        $comment = Comment::first();
        factory(Comment::class)->create([
           'post_id' => $post->id,
           'user_id' => $this->user->id,
           'parent_id' => $comment->id,
        ]);
    }

    /**
    * Make user to login
    *
    * @return void
    */
    public function makeUserLogin()
    {
        return factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }
}
