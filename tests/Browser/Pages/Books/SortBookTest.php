<?php

namespace Tests\Browser\Pages\Books;

use App\Model\User;
use App\Model\Book;
use App\Model\Donator;
use App\Model\Category;
use Tests\DuskTestCase;
use App\Model\Borrowing;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SortBookTest extends BaseTestUser
{
    use DatabaseMigrations;

    private $adminUserToLogin;
    
    /**
    * Override function setUp()
    *
    * @return void
    */
    public function setUp()
    {
        parent::setUp();
        $this->adminUserToLogin = $this->makeAdminUserToLogin();
        $baseTestBook = new BaseTestBook();
        $baseTestBook->makeListOfBook(16);
    }

    /**
    * A Dusk test sort by Name Asc has paginate
    *
    * @return void
    */
    public function testSortNamePaginateAsc()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=name&order=asc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('name', 'ASC')->skip(10)->take(6)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=name&order=asc')
                ->clickLink('Name')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('name', 'DESC')->limit(10)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=name&order=desc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('name', 'Desc')->skip(10)->take(6)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books')
                ->clickLink('Author')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('author', 'ASC')->limit(10)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=author&order=asc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('author', 'ASC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=author&order=asc')
                ->clickLink('Author')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('author', 'Desc')->limit(10)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=author&order=desc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('author', 'DESC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books')
                ->clickLink('Rating')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('avg_rating', 'Asc')->limit(10)->get();
            $checkAvgRating = false;
            foreach ($books as $index => $book) {
                $bookAvgRating = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=avg_rating&order=asc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('avg_rating', 'ASC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=avg_rating&order=asc')
                ->clickLink('Rating')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('avg_rating', 'Desc')->limit(10)->get();
            $checkAvgRating = false;
            foreach ($books as $index => $book) {
                $bookAvgRating = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=avg_rating&order=desc&page=2')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-desc');
            $books = Book::orderBy('avg_rating', 'DESC')->skip(10)->take(6)->get();
            $checkAuthor = false;
            foreach ($books as $index => $book) {
                $bookAuthor = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books')
                ->clickLink('Total borrow')
                ->resize(1200, 1600)
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
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=borrowings_count&order=asc&page=2')
                ->resize(1200, 1600)
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
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=borrowings_count&order=asc')
                ->clickLink('Total borrow')
                ->resize(1200, 1600)
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
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books?sort=borrowings_count&order=desc&page=2')
                ->resize(1200, 1600)
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
                $bookTotal = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
                $checkTotal = $book->borrowing == $bookTotal;
                if (!$checkTotal) {
                    break;
                }
            }
            $this->assertTrue($checkTotal);
        });
    }

    /**
     * A Dusk test sort by Name Asc
     *
     * @return void
     */
    public function testSortNameAsc()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/books')
                ->clickLink('Name')
                ->resize(1200, 1600)
                ->assertSee('LIST OF BOOK')
                ->assertVisible('.fa.fa-sort-asc');
            $books = Book::orderBy('name', 'ASC')->limit(10)->get();
            $checkName = false;
            foreach ($books as $index => $book) {
                $bookName = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkName = $book->name == $bookName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }
}
