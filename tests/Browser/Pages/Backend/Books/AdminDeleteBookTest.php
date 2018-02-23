<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Favorite;
use Faker\Factory as Faker;

class AdminDeleteBookTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * When go to list books without login, move to '/login'.
     *
     * @return void
     */
    public function testDeleteBookWithoutLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1600, 1200)
                ->visit('/admin/books')
                ->assertPathIs('/login');
        });
    }

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
                ->resize(1600, 1200)
                ->visit('/admin/books')
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
                ->resize(1600, 1200)
                ->visit('/admin/books')
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa-trash-o[book-id="'. $bookID. '"]')
                ->assertVisible('.fa-trash-o')
                ->assertMissing('.bg-color-gray')
                ->assertMissing('.fa-history');
        });
    }

    /**
     * When click delete button, book and its relationship was soft deleted.
     *
     * @return void
     */
    public function testClickDelete()
    {
        $this->makeBooksAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1600, 1200)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->assertMissing('.fa-trash-o[book-id="'. $bookID. '"]')
                ->assertVisible('.fa-history[book-id="'. $bookID. '"]')
                ->assertVisible('.bg-color-gray');
        });

        //Book and its favorites.
        $this->assertSoftDeleted('books', [
            'id' => $bookID,
        ]);
        $favoriteBookIds = DB::table('favorites')->where('favoritable_id', $bookID)->where('favoritable_type', Favorite::TYPE_BOOK)->pluck('id')->toArray();
        foreach ($favoriteBookIds as $favoriteBookID) {
            $this->assertSoftDeleted('favorites', [
                'id' => $favoriteBookID,
            ]);
        }

        //QrCodes, borrowings, ratings.
        $qrcodeIds = DB::table('qrcodes')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($qrcodeIds as $qrcodeID) {
            $this->assertSoftDeleted('qrcodes', [
                'id' => $qrcodeID,
            ]);
        }
        $borrowingIds = DB::table('borrowings')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($borrowingIds as $borrowingID) {
            $this->assertSoftDeleted('borrowings', [
                'id' => $borrowingID,
            ]);
        }
        $ratingIds = DB::table('ratings')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($ratingIds as $ratingID) {
            $this->assertSoftDeleted('ratings', [
                'id' => $ratingID,
            ]);
        }

        //Posts and its relationship.
        $postIds = DB::table('posts')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($postIds as $postID) {
            $this->assertSoftDeleted('posts', [
                'id' => $postID,
            ]);
        }
        $favoritePostIds = DB::table('favorites')->whereIn('favoritable_id', $postIds)->where('favoritable_type', Favorite::TYPE_POST)->pluck('id')->toArray();
        foreach ($favoritePostIds as $favoritePostID) {
            $this->assertSoftDeleted('favorites', [
                'id' => $favoritePostID,
            ]);
        }

        //Comments and its relationship.            
        $commentIds = DB::table('comments')->whereIn('post_id', $postIds)->pluck('id')->toArray();
        foreach ($commentIds as $commentID) {
            $this->assertSoftDeleted('comments', [
                'id' => $commentID,
            ]);
        }
        $favoriteCommentIds = DB::table('favorites')->whereIn('favoritable_id', $commentIds)->where('favoritable_type', Favorite::TYPE_COMMENT)->pluck('id')->toArray();
        foreach ($favoriteCommentIds as $favoriteCommentID) {
            $this->assertSoftDeleted('favorites', [
                'id' => $favoriteCommentID,
            ]);
        }
    }

    /**
     * When click restore button, book and its relationship was restored.
     *
     * @return void
     */
    public function testClickRestore()
    {
        $this->makeBooksAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1600, 1200)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->assertVisible('.fa-trash-o[book-id="'. $bookID. '"]')
                ->assertMissing('.bg-color-gray')
                ->assertMissing('.fa-history');
        });

        //Book and its favorites.
        $this->assertDatabaseHas('books', [
            'id' => $bookID,
            'deleted_at' => null,
        ]);
        $favoriteBookIds = DB::table('favorites')->where('favoritable_id', $bookID)->where('favoritable_type', Favorite::TYPE_BOOK)->pluck('id')->toArray();
        foreach ($favoriteBookIds as $favoriteBookID) {
            $this->assertDatabaseHas('favorites', [
                'id' => $favoriteBookID,
                'deleted_at' => null,
            ]);
        }

        //QrCodes, borrowings, ratings.
        $qrcodeIds = DB::table('qrcodes')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($qrcodeIds as $qrcodeID) {
            $this->assertDatabaseHas('qrcodes', [
                'id' => $qrcodeID,
                'deleted_at' => null,
            ]);
        }
        $borrowingIds = DB::table('borrowings')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($borrowingIds as $borrowingID) {
            $this->assertDatabaseHas('borrowings', [
                'id' => $borrowingID,
                'deleted_at' => null,
            ]);
        }
        $ratingIds = DB::table('ratings')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($ratingIds as $ratingID) {
            $this->assertDatabaseHas('ratings', [
                'id' => $ratingID,
                'deleted_at' => null,
            ]);
        }

        //Posts and its relationship.
        $postIds = DB::table('posts')->where('book_id', $bookID)->pluck('id')->toArray();
        foreach ($postIds as $postID) {
            $this->assertDatabaseHas('posts', [
                'id' => $postID,
                'deleted_at' => null,
            ]);
        }
        $favoritePostIds = DB::table('favorites')->whereIn('favoritable_id', $postIds)->where('favoritable_type', Favorite::TYPE_POST)->pluck('id')->toArray();
        foreach ($favoritePostIds as $favoritePostID) {
            $this->assertDatabaseHas('favorites', [
                'id' => $favoritePostID,
                'deleted_at' => null,
            ]);
        }

        //Comments and its relationship.            
        $commentIds = DB::table('comments')->whereIn('post_id', $postIds)->pluck('id')->toArray();
        foreach ($commentIds as $commentID) {
            $this->assertDatabaseHas('comments', [
                'id' => $commentID,
                'deleted_at' => null,
            ]);
        }
        $favoriteCommentIds = DB::table('favorites')->whereIn('favoritable_id', $commentIds)->where('favoritable_type', Favorite::TYPE_COMMENT)->pluck('id')->toArray();
        foreach ($favoriteCommentIds as $favoriteCommentID) {
            $this->assertDatabaseHas('favorites', [
                'id' => $favoriteCommentID,
                'deleted_at' => null,
            ]);
        }
    }

    /**
     * When click delete button, can't click edit button of this book.
     *
     * @return void
     */
    public function testDisabledButtonEditOfBookWasDeleted()
    {
        $this->makeBooksAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1600, 1200)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->assertVisible('.btn-edit-'. $bookID. '[disabled="disabled"]');
        });
    }

    /**
     * When delete book was deleted, display modal with message.
     *
     * @return void
     */
    public function testDeleteBookWasDeleted()
    {
        $this->makeBooksAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1600, 1200)
                ->visit('/admin/books');
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
            $browser->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->assertSee('This book is not found');
        });
    }

    /**
     * When restore book was restored, display modal with message.
     *
     * @return void
     */
    public function testRestoreBookWasRestored()
    {
        $this->makeBooksAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
                ->resize(1600, 1200)
                ->visit('/admin/books')
                ->press('[book-id="'. $bookID. '"]')
                ->pause(3000);
        $this->withoutMiddleware();
        $this->call('PUT', '/api/books/'. $bookID. '/restore');
            $browser->press('[book-id="'. $bookID. '"]')
                ->pause(3000)
                ->assertSee('This book is not found');
        });
    }

    /**
     * When delete books with GET method, book not deleted.
     *
     * @return void
     */
    public function testDeleteBookWithGetMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('GET', '/api/books/'. $bookID);
        $this->assertDatabaseHas('books', [
            'id' => $bookID,
            'deleted_at' => null
        ]);
    }

    /**
     * When delete books with POST method, book not deleted.
     *
     * @return void
     */
    public function testDeleteBookWithPostMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('POST', '/api/books/'. $bookID);
        $this->assertDatabaseHas('books', [
            'id' => $bookID,
            'deleted_at' => null
        ]);
    }

    /**
     * When delete books with PUT method, book not deleted.
     *
     * @return void
     */
    public function testDeleteBookWithPutMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('PUT', '/api/books/'. $bookID);
        $this->assertDatabaseHas('books', [
            'id' => $bookID,
            'deleted_at' => null
        ]);
    }

    /**
     * When delete books with DELETE method, book was deleted.
     *
     * @return void
     */
    public function testDeleteBookWithDeleteMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
        $this->assertSoftDeleted('books', [
            'id' => $bookID,
        ]);
    }

    /**
     * When restore books with GET method, book not restored.
     *
     * @return void
     */
    public function testRestoreBookWithGetMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
        $this->call('GET', '/api/books/'. $bookID. '/restore');
        $this->assertSoftDeleted('books', [
            'id' => $bookID,
        ]);
    }

    /**
     * When restore books with POST method, book not restored.
     *
     * @return void
     */
    public function testRestoreBookWithPostMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
        $this->call('POST', '/api/books/'. $bookID. '/restore');
        $this->assertSoftDeleted('books', [
            'id' => $bookID,
        ]);
    }

    /**
     * When restore books with PUT method, book was restored.
     *
     * @return void
     */
    public function testRestoreBookWithPutMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
        $this->call('PUT', '/api/books/'. $bookID. '/restore');
        $this->assertDatabaseHas('books', [
            'id' => $bookID,
            'deleted_at' => null,
        ]);
    }

    /**
     * When restore books with DELETE method, book not restored.
     *
     * @return void
     */
    public function testRestoreBookWithDeleteMethod() {
        $this->makeListOfBook(1);
        $bookID = DB::table('books')->pluck('id')->first();
        $this->withoutMiddleware();
        $this->call('DELETE', '/api/books/'. $bookID);
        $this->call('DELETE', '/api/books/'. $bookID. '/restore');
        $this->assertSoftDeleted('books', [
            'id' => $bookID,
        ]);
    }
}
