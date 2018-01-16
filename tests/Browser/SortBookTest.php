<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use App\Model\Borrowing;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SortBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();

        factory(Category::class, 5)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        factory(User::class, 5)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        factory(Donator::class, 5)->create([
            'user_id' => $faker->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        for ($i = 0; $i <= 16; $i++)
        {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds),
                'name' => $faker->sentence(rand(2,5)),
                'author' => $faker->name,
            ]);
        }

        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i = 0; $i <= 16; $i++)
        {
            $borrowing = factory(Borrowing::class, 1)->create([
                'book_id' =>  $faker->randomElement($bookIds),
                'user_id' =>  $faker->randomElement($userIds),
            ]);
        }

    }

    /**
    * A Dusk test sort by Name Asc
    *
    * @return void
    */
    public function testSortNameAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->clickLink('Name')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('name', 'ASC')->limit(10)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $book->name == $bookName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
    * A Dusk test sort by Name Asc has paginate
    *
    * @return void
    */
    public function testSortNamePaginateAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=name&order=asc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::orderBy('name', 'ASC')->skip(10)->take(6)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $book->name === $bookName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
    * A Dusk test sort by Name Desc
    *
    * @return void
    */
    public function testSortNameDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=name&order=asc')
                    ->clickLink('Name')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('name', 'DESC')->limit(10)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $book->name === $bookName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
    * A Dusk test sort by Name Desc has paginate
    *
    * @return void
    */
    public function testSortNamePaginateDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=name&order=desc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc')
                    ->screenShot(1);

            $books = Book::orderBy('name', 'Desc')->skip(10)->take(6)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $book->name === $bookName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
    * A Dusk test sort by Author Asc
    *
    * @return void
    */
    public function testSortAuthorAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->clickLink('Author')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::orderBy('author', 'ASC')->limit(10)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkAuthor = $book->author === $bookAuthor;
                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by Author Asc paginate
    *
    * @return void
    */
    public function testSortAuthorPaginateAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=author&order=asc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::orderBy('author', 'ASC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkAuthor = $book->author === $bookAuthor;
                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by Author Desc
    *
    * @return void
    */
    public function testSortAuthorDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=author&order=asc')
                    ->clickLink('Author')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::orderBy('author', 'Desc')->limit(10)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');

                $checkAuthor = $book->author === $bookAuthor;

                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by Author Desc paginate
    *
    * @return void
    */
    public function testSortAuthorPaginateDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=author&order=desc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::orderBy('author', 'DESC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkAuthor = $book->author === $bookAuthor;
                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by avg_rating Asc
    *
    * @return void
    */
    public function testSortAvgRatingAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->clickLink('Average review score')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::orderBy('avg_rating', 'Asc')->limit(10)->get();
            $checkAvgRating = false;
            foreach ($books as $index => $book) {
                $bookAvgRating = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkAvgRating = $book->avg_rating == $bookAvgRating;
                if (!$checkAvgRating) {
                    break;
                }
            }
            $this->assertTrue($checkAvgRating);
        });
    }

    /**
    * A Dusk test sort by avg_rating Asc paginate
    *
    * @return void
    */
    public function testSortAvgRatingPaginateAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=avg_rating&order=asc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::orderBy('avg_rating', 'ASC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkAuthor = $book->avg_rating == $bookAuthor;
                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by avg_rating Desc
    *
    * @return void
    */
    public function testSortAvgRatingDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=avg_rating&order=asc')
                    ->clickLink('Average review score')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::orderBy('avg_rating', 'Desc')->limit(10)->get();
            $checkAvgRating = false;
            foreach ($books as $index => $book) {
                $bookAvgRating = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkAvgRating = $book->avg_rating == $bookAvgRating;
                if (!$checkAvgRating) {
                    break;
                }
            }
            $this->assertTrue($checkAvgRating);
        });
    }

    /**
    * A Dusk test sort by avg_rating Desc paginate
    *
    * @return void
    */
    public function testSortAvgRatingPaginateDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=avg_rating&order=desc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::orderBy('avg_rating', 'DESC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkAuthor = $book->avg_rating == $bookAuthor;
                if (!$checkAuthor) {
                    break;
                }
            }
            $this->assertTrue($checkAuthor);
        });
    }

    /**
    * A Dusk test sort by total borrowings Asc
    *
    * @return void
    */
    public function testSortTotalBorrowingAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->clickLink('Total borrow')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::select('books.id', 'books.name', 'books.author', 'books.avg_rating', 'borrowings.book_id')
                   ->addselect(DB::raw('count(borrowings.book_id) as borrowing'))
                   ->leftJoin('borrowings', 'borrowings.book_id', '=', 'books.id')
                   ->groupby('books.id')
                   ->orderBy('borrowing', 'Asc')
                   ->limit(10)->get();
            $checkTotal = false;
            foreach ($books as $index => $book) {
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkTotal = $book->borrowing == $bookTotal;
                if (!$checkTotal) {
                    break;
                }
            }
            $this->assertTrue($checkTotal);
        });
    }

    /**
    * A Dusk test sort by total borrowings Asc paginate
    *
    * @return void
    */
    public function testSortTotalBorrowingPaginateAsc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=borrowings_count&order=asc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-asc');

            $books = Book::select('books.id', 'books.name', 'books.author', 'books.avg_rating', 'borrowings.book_id')
                   ->addselect(DB::raw('count(borrowings.book_id) as borrowing'))
                   ->leftJoin('borrowings', 'borrowings.book_id', '=', 'books.id')
                   ->groupby('books.id')
                   ->orderBy('borrowing', 'Asc')
                   ->skip(10)->take(6)->get();

            $checkTotal = false;
            foreach ($books as $index => $book) {
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkTotal = $book->borrowing == $bookTotal;
                if (!$checkTotal) {
                    break;
                }
            }
            $this->assertTrue($checkTotal);
        });
    }

    /**
    * A Dusk test sort by total borrowings Desc
    *
    * @return void
    */
    public function testSortTotalBorrowingDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=borrowings_count&order=asc')
                    ->clickLink('Total borrow')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::select('books.id', 'books.name', 'books.author', 'books.avg_rating', 'borrowings.book_id')
                   ->addselect(DB::raw('count(borrowings.book_id) as borrowing'))
                   ->leftJoin('borrowings', 'borrowings.book_id', '=', 'books.id')
                   ->groupby('books.id')
                   ->orderBy('borrowing', 'Desc')
                   ->limit(10)->get();

            $checkTotal = false;
            foreach ($books as $index => $book) {
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkTotal = $book->borrowing == $bookTotal;
                if (!$checkTotal) {
                    break;
                }
            }
            $this->assertTrue($checkTotal);
        });
    }

    /**
    * A Dusk test sort by total borrowings Desc paginate
    *
    * @return void
    */
    public function testSortTotalBorrowingPaginateDesc()
    {
        $this->makeData();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books?sort=borrowings_count&order=desc&page=2')
                    ->resize(900, 1200)
                    ->assertSee('LIST OF BOOK')
                    ->assertVisible('.fa.fa-sort-desc');

            $books = Book::select('books.id', 'books.name', 'books.author', 'books.avg_rating', 'borrowings.book_id')
                   ->addselect(DB::raw('count(borrowings.book_id) as borrowing'))
                   ->leftJoin('borrowings', 'borrowings.book_id', '=', 'books.id')
                   ->groupby('books.id')
                   ->orderBy('borrowing', 'Desc')
                   ->skip(10)->take(6)->get();

            $checkTotal = false;
            foreach ($books as $index => $book) {
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkTotal = $book->borrowing == $bookTotal;

                if (!$checkTotal) {
                    break;
                }
            }
            $this->assertTrue($checkTotal);
        });
    }
}
