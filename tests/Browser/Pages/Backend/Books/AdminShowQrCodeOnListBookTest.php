<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\Book;
use App\Model\User;
use Faker\Factory as Faker;

class AdminShowQrCodeOnListBookTest extends BaseTestBook
{
    use DatabaseMigrations;

    public function testConfirmQrCodeInColumn2ndOfListBook()
    {
        $this->makeListOfBook(1);
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                ->resize(2000, 1600)
                ->visit('/admin/books')
                ->assertSeeIn('#table-book thead tr:nth-child(1) th:nth-child(2)', 'QR Code');
        });
    }

    public function testCompareQrCodeInDatabase()
    {
        $this->makeListOfBook(10);
        $fields = [
            'books.id as id',
            'qrcodes.prefix as prefix',
            'qrcodes.code_id as code'
        ];
        $books = Book::select($fields)->join('qrcodes', 'books.id', 'qrcodes.book_id')->orderBy('id', 'desc');
        $userLogin = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin, $books) {
            $browser->loginAs($userLogin)
                ->resize(2000, 1600)
                ->visit('/admin/books');
            for ($index = 0; $index <=9; $index++) {
                $book = $books->get()[$index];
                $rows = $index + 1;
                $browser->assertSeeIn('#table-book tbody tr:nth-child(' . $rows . ') td:nth-child(1)', $book->id)
                    ->assertSeeIn('#table-book tbody tr:nth-child(' . $rows . ') td:nth-child(2)', $book->prefix . $book->code);
            }
        });
    }
}
