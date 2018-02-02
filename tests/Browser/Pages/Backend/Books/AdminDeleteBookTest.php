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
                    ->press('[book-id="'.$book->id.'"]')
                    ->pause(1000)
                    ->assertVisible('.bg-color-gray')
                    ->assertVisible('.fa-history');
        });
        $this->assertSoftDeleted('books', [
            'id' => $book->id,
            'category_id' => $book->category_id,
            'donator_id' => $book->donator_id,
            'name' => $book->name,
            'author' => $book->author,
            'year' => $book->year,
            'price' => $book->price,
            'description' => $book->description,
            'avg_rating' => $book->avg_rating,
            'total_rating' => $book->total_rating,
            'status' => $book->status,
        ]);
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
                    ->press('[book-id="'.$bookID.'"]')
                    ->pause(1000)
                    ->visit('/admin/books')
                    ->assertMissing('#'.$bookID);
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
        $book = DB::table('books')->first();
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $book) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/books')
                    ->press('[book-id="'.$book->id.'"]')
                    ->pause(1000)
                    ->press('[book-id="'.$book->id.'"]')
                    ->pause(1000)
                    ->assertVisible('#'.$book->id)
                    ->assertVisible('.fa-trash-o')
                    ->assertMissing('.bg-color-gray')
                    ->assertMissing('.fa-history');
        });
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'category_id' => $book->category_id,
            'donator_id' => $book->donator_id,
            'name' => $book->name,
            'author' => $book->author,
            'year' => $book->year,
            'price' => $book->price,
            'description' => $book->description,
            'avg_rating' => $book->avg_rating,
            'total_rating' => $book->total_rating,
            'status' => $book->status,
            'deleted_at' => null,
        ]);
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
                    ->press('[book-id="'.$bookID.'"]')
                    ->pause(1000)
                    ->press('[book-id="'.$bookID.'"]')
                    ->pause(1000)
                    ->visit('/admin/books')
                    ->assertVisible('#'.$bookID);
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
                    ->press('[book-id="'.$bookID.'"]')
                    ->pause(1000)
                    ->press('.btn-edit-'.$bookID)
                    ->pause(1000)
                    ->assertPathIs('/admin/books');
        });
    }
}
