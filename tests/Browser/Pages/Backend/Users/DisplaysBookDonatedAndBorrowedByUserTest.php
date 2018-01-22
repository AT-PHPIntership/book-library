<?php

namespace Tests\Browser\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Book;
use App\Model\Donator;
use App\Model\Borrowing;
use App\Model\Category; 
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DisplaysDonatedAndBorrowedBooksByUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test route from list users go to list books donated or borrowed of user.
     *
     * @return void
     */
    public function testRouteDisplayBooks()
    {
        factory(User::class, 1)->create([
            'role' => 1
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/admin/users')
                ->click('.bookuser')
                ->assertPathIs('/admin/books')
                ->assertSee('LIST OF BOOK');
        });
    }

    /**
     * make data test.
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();

        factory(Category::class, 1)->create();

        factory(User::class, 1)->create([
            'role' => 1
        ]);

        factory(Donator::class, 1)->create([
            'user_id' => 1
        ]);

        factory(Book::class, 1)->create([
            'category_id' => 1,
            'donator_id' => 1,
            'name' => $faker->sentence(rand(2,5)),
            'author' => $faker->name,
        ]);

        factory(Borrowing::class, 1)->create([
            'book_id' =>  1,
            'user_id' =>  1,
        ]);
    }

    /**
    * Test Display total donated and borrowed books in page list users
    *
    * @return void
    */
    public function testNumberOfDonatedAndBorrowedBooks()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users');  
            $fields = [
                'users.id',
                'users.employee_code',
                'users.name',
                'users.email',
                DB::raw('COUNT(DISTINCT(borrowings.id)) AS total_borrowed'),
                DB::raw('COUNT(DISTINCT(books.id)) AS total_donated'),
            ];
            $users = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
            ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
            ->leftJoin('books', 'donators.id', 'books.donator_id')
            ->select($fields)
            ->groupBy('users.id')
            ->first();
            $totalDonator = $browser->text('#example2 tbody tr:nth-child(1) td:nth-child(5)');
			$totalBorrow = $browser->text('#example2 tbody tr:nth-child(1) td:nth-child(6)');
			$this->assertTrue($users->total_donated == $totalDonator);
            $this->assertTrue($users->total_borrowed == $totalBorrow);
        });
    }

    /**
    * in list users, click number of donated books by user go to page lists books display name of donated books
    *
    * @return void
    */
    public function testDetailofDonatedBooks()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books?uid=1&filter=donated')
                    ->assertSee('LIST OF BOOK')
                    ->assertQueryStringHas('uid', '1')
                    ->assertQueryStringHas('filter', 'donated');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
    * in list users, click number of borrowed books by user go to page books display name of borrowed books
    *
    * @return void
    */
    public function testDetailofBorrowedBooks()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books?uid=1&filter=borrowed')
                    ->assertSee('LIST OF BOOK')
                    ->assertQueryStringHas('uid', '1')
                    ->assertQueryStringHas('filter', 'borrowed');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $elements);
        });
    }
}
