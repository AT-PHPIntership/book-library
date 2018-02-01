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
    * Looking button delete comment in post page
    *
    * @return void
    */
    public function testSeeButtonDeleteComment()
    {
        $this->makeData(1);
        $post = Post::first();
        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success')
                    ->click('.btn.btn-success')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id)
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
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
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
        $this->makeData(1);
        $post = Post::first();
        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success')
                    ->click('.btn.btn-success')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id)
                    ->assertVisible('.glyphicon.glyphicon-remove.text-warning')
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
        $this->makeData(1);
        $post = Post::first();
        $comments = Comment::where('post_id',$post->id)->get();
        $count = count($comments);

        $this->browse(function (Browser $browser) use ($post, $count) {
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success');
            $this->assertTrue(2 == $count);
            $browser->click('.btn.btn-success')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id)
                    ->assertVisible('.glyphicon.glyphicon-remove.text-warning')
                    ->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->assertSee('Confirm Delete')
                    ->assertSee('OK')
                    ->assertSee('Close')
                    ->press('Close')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id);
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
        $this->makeData(1);
        $post = Post::first();
        $comments = Comment::where('post_id',$post->id)->get();
        $count = count($comments);

        $this->browse(function (Browser $browser) use ($post, $count) {
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success');
            $this->assertTrue(2 == $count);
            $browser->click('.btn.btn-success')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id)
                    ->assertVisible('.glyphicon.glyphicon-remove.text-warning')
                    ->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->assertSee('Confirm Delete')
                    ->assertSee('OK')
                    ->assertSee('Close')
                    ->press('OK')
                    ->pause(1000)
                    ->assertSee('Success! Delete Comments');
            $commentLast = Comment::where('post_id',$post->id)->get();
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
        $this->makeData(1);
        $post = Post::first();
        $comment = Comment::where('post_id',$post->id)->where('parent_id','!=', null)->first();
        $this->browse(function (Browser $browser) use ($post, $comment) {
            $browser->loginAs(User::find(1))
                    ->resize(1200,1600)
                    ->visit('/admin/posts')
                    ->assertSee('List Posts')
                    ->assertVisible('.btn.btn-success');
            $this->assertTrue(1 == count($comment));
            $browser->click('.btn.btn-success')
                    ->visit('/admin/posts/'.$post->id)
                    ->assertPathIs('/admin/posts/'.$post->id)
                    ->assertVisible('.glyphicon.glyphicon-remove.text-warning')
                    ->click('.glyphicon.glyphicon-remove.text-warning')
                    ->pause(1000)
                    ->assertSee('Confirm Delete')
                    ->assertSee('OK')
                    ->assertSee('Close')
                    ->press('OK')
                    ->pause(1000)
                    ->assertSee('Success! Delete Comments');
                $commentLast = Comment::where('post_id',$post->id)->where('parent_id','!=', null)->first();
                $this->assertTrue(0 == count($commentLast));
        });
    }

    /**
    * Make data has comment
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

        factory(Post::class, 1)->create([
            'user_id' => $faker->randomElement($userIds),
            'book_id' => $faker->randomElement($bookIds),
        ]);

       $post = Post::first();
       factory(Comment::class, 1)->create([
           'post_id' => $post->id,
           'user_id' => $faker->randomElement($userIds),
           'parent_id' => null,
       ]);

       $comment = Comment::first();
        factory(Comment::class, 1)->create([
           'post_id' => $post->id,
           'user_id' => $faker->randomElement($userIds),
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
        factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }
}
