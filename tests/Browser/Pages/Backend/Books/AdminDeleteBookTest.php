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
     * When click delete button, book's relationship was soft deleted.
     *
     * @return void
     */
    public function testClickDelete()
    {
        $this->makeBookAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
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
     * When click restore button, book's relationship was restored.
     *
     * @return void
     */
    public function testClickRestore()
    {
        $this->makeBookAndItsRelationship();
        $bookID = DB::table('books')->pluck('id')->get(rand(0,9));
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $bookID) {
            $browser->loginAs($userLogin)
            ->resize(1200, 900)
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
}
