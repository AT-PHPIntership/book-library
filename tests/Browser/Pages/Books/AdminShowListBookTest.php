<?php

namespace Tests\Browser\tests\Browser\Pages\BackEnd\Books;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\QrCode;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminShowListBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeListOfBook($rows)
    {
        $faker = Faker::create();

        $category = factory(Category::class)->create();

        factory(User::class)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        $donator = factory(Donator::class)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);

        for ($i = 0;$i <= $rows; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $category->id,
                'donator_id' => $donator->id,
            ]);
        }
        $books = Book::all();

        foreach ($books as $book) {
            factory(QrCode::class, 1)->create([
                    'book_id' => $book->id,
                    'code_id' => $faker->unique()->randomNumber(3),
                    'prefix' => 'BAT-',
            ]);
        }
    }

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeUser(){
        factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }

    /**
     * Check page with showing only 10 rows on page 1
     *
     * @return void
     */
    public function testShowListBook()
    {
        $this->makeUser();
        $this->makeListOfBook(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books/')
                    ->resize(1200, 1600)
                    ->assertTitle('Admin | LIST OF BOOK');
            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(10, $elements);
        });
    }

    /**
     * Test page 2 showing only 5 rows.
     *
     * @return void
     */
    public function testShowPageListBook()
    {
        $this->makeUser();
        $this->makeListOfBook(15);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                        ->visit('/admin/books')
                        ->resize(900, 1600)
                        ->click('.pagination li:nth-child(3) a');

            $elements = $browser->elements('#table-book tbody tr');
            $this->assertCount(6, $elements);
            $browser->assertQueryStringHas('page', 2);
            $this->assertNotNull($browser->element('.pagination'));
        });
    }

    /**
     * Test page empty.
     *
     * @return void
     */
    public function testEmptyPage()
    {
        $this->makeUser();
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/books')
                ->resize(900, 1600)
                ->assertSee('Sorry, Not be found.')
                ->assertTitle('Admin | LIST OF BOOK');
        $elements = $browser->elements('#table-book tbody tr');
        $this->assertNull($browser->element('.pagination'));
        });
    }
}
