<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Donator;
use App\Model\Borrowing;
use App\Model\QrCode;
use App\Model\Rating;
use App\Model\Post;
use App\Model\Comment;
use App\Model\Favorite;
use Faker\Factory as Faker;

class AdminDeleteBookTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * If role of user was logining is "User", move to "/login" with message.
     *
     * @return void
     */
    public function testLoginAdminPageWithUserAccount()
    {
        $userLogin = factory(User::class)->create(['role' => User::ROLE_USER]);
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/users')
            ->assertPathIs('/login')
            ->assertSee('You are NOT an Administrator');
        });
    }

    /**
     * User was logining has role "Admin".
     * If list book not null, it can see button delete and can't see button restore.
     *
     * @return void
     */
    public function testLoginAdminPageWithAdminAccount()
    {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->assertSee('LIST OF BOOK')
            ->assertVisible('#'.$bookID)
            ->assertVisible('.fa-trash-o')
            ->assertMissing('.bg-color-gray')
            ->assertMissing('.fa-history');
        });
    }

    /**
     * When click delete button, it change to restore button and the row contains it
     * change background color to gray. The book was deleted
     *
     * @return void
     */
    public function testClickDeleteBook()
    {
        $this->makeListOfBook(1);
        $book = DB::table('books')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $book) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->press('[book-id="'. $book->id. '"]')
            ->pause(1000)
            ->assertVisible('.bg-color-gray')
            ->assertVisible('.fa-history');
        });
    }

    /**
     * When click delete button and reload page, can't see this book.
     *
     * @return void
     */
    public function testClickDeleteBookAndReloadPage()
    {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->visit('/admin/books')
            ->assertMissing('#'. $bookID);
        });
    }

    /**
     * When click restore button, this book was restored. Button restore change to button delete.
     *
     * @return void
     */
    public function testClickRestore()
    {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->assertVisible('#'. $bookID)
            ->assertVisible('.fa-trash-o')
            ->assertMissing('.bg-color-gray')
            ->assertMissing('.fa-history');
        });
    }

    /**
     * When click restore button and reload page, can see this book.
     *
     * @return void
     */
    public function testClickRestoreAndReloadPage()
    {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->visit('/admin/books')
            ->assertVisible('#'. $bookID);
        });
    }

    /**
     * When click delete button, can't click edit button of this book.
     *
     * @return void
     */
    public function testClickEditBookWasDeleted()
    {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
            ->visit('/admin/books')
            ->press('[book-id="'. $bookID. '"]')
            ->pause(1000)
            ->press('.btn-edit-'. $bookID)
            ->pause(1000)
            ->assertPathIs('/admin/books');
        });
    }

    /**
     * When click delete button, book's relationship was soft deleted.
     *
     * @return void
     */
    public function testDatabaseWhenDeleted()
    {
        $this->makeABookAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1200, 900)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(1000);
        });
        $this->assertSoftDeleted('books', ['id' => $bookID])
            ->assertSoftDeleted('qrcodes', ['book_id' => $bookID])
            ->assertSoftDeleted('borrowings', ['book_id' => $bookID])
            ->assertSoftDeleted('ratings', ['book_id' => $bookID])
            ->assertSoftDeleted('posts', ['book_id' => $bookID])
            ->assertSoftDeleted('favorites', [
                'favoritable_id' => $bookID,
                'favoritable_type' => Favorite::TYPE_BOOK,
            ]);
        $posts = Post::withTrashed()->select('id')->where('book_id', $bookID);
        foreach ($posts as $post) {
            $this->assertSoftDeleted('favorites', [
                'favoritable_id' => $post,
                'favoritable_type' => Favorite::TYPE_POST,
            ])
                ->assertSoftDeleted('comments', ['post_id' => $post]);
            $comments = Comment::withTrashed()->select('id')->where('post_id', $post);
            foreach ($comments as $comment) {
                $this->assertSoftDeleted('favorites', [
                    'favoritable_id' => $comment,
                    'favoritable_type' => Favorite::TYPE_COMMENT,
                ]);
            }
        }
    }

    /**
     * When click restore button, book's relationship was restored.
     *
     * @return void
     */
    public function testDatabaseWhenRestored()
    {
        $this->makeABookAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1200, 900)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(1000)
                ->press('[book-id="'. $bookID. '"]')
                ->pause(1000);
        });
        $this->assertDatabaseHas('books', [
                'id' => $bookID,
                'deleted_at' => null,
            ])
            ->assertDatabaseHas('qrcodes', [
                'book_id' => $bookID,
                'deleted_at' => null,
            ])
            ->assertDatabaseHas('borrowings', [
                'book_id' => $bookID,
                'deleted_at' => null,
            ])
            ->assertDatabaseHas('ratings', [
                'book_id' => $bookID,
                'deleted_at' => null,
            ])
            ->assertDatabaseHas('posts', [
                'book_id' => $bookID,
                'deleted_at' => null,
            ])
            ->assertDatabaseHas('favorites', [
                'favoritable_id' => $bookID,
                'favoritable_type' => Favorite::TYPE_BOOK,
                'deleted_at' => null,
            ]);
        $posts = Post::withTrashed()->select('id')->where('book_id', $bookID);
        foreach ($posts as $post) {
            $this->assertDatabaseHas('favorites', [
                'favoritable_id' => $post,
                'favoritable_type' => Favorite::TYPE_POST,
                'deleted_at' => null,
            ])
                ->assertDatabaseHas('comments', [
                    'post_id' => $post,
                    'deleted_at' => null,
                ]);
            $comments = Comment::withTrashed()->select('id')->where('post_id', $post);
            foreach ($comments as $comment) {
                $this->assertDatabaseHas('favorites', [
                    'favoritable_id' => $comment,
                    'favoritable_type' => Favorite::TYPE_COMMENT,
                    'deleted_at' => null,
                ]);
            }
        }
    }
}
