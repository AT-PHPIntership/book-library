<?php

namespace Tests\Browser\tests\Browser\Pages\BackEnd\Books;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use App\Model\QrCode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SortBorrowingsTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * Create setup function use for login
     *
     * @return void
     */
    public function setUp()
     {
         parent::setUp();
         factory(User::class)->create(['role' => User::ROLE_ADMIN]);
     }

    /**
     * Test sort ASC Employee_code
     *
     * @return void
     */
    public function testSortEmployeeCodeASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings/')
                    ->resize(900, 1600)
                    ->clickLink('Employee code')
                    ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('employee_code', 'ASC')
                ->limit(10)->get();

            $checkEmployeeCode = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmployeeCode = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(1)');
                $checkEmployeeCode = $borrowing->employee_code == $borrowingEmployeeCode;
                if (!$checkEmployeeCode) {
                    break;
                }
            }
            $this->assertTrue($checkEmployeeCode);
        });
    }

    /**
     * Test sort DESC Employee_code
     *
     * @return void
     */
    public function testSortEmployeeCodeDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings/')
                    ->resize(900, 1600)
                    ->clickLink('Employee code')
                    ->clickLink('Employee code')
                    ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('employee_code', 'desc')
                ->limit(10)->get();

            $checkEmployeeCode = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmployeeCode = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(1)');
                $checkEmployeeCode = $borrowing->employee_code == $borrowingEmployeeCode;
                if (!$checkEmployeeCode) {
                    break;
                }
            }
            $this->assertTrue($checkEmployeeCode);
        });
    }

    /**
     * Test sort DESC Employee_code has pagination
     *
     * @return void
     */
    public function testSortEmployeeCodeDESCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings?sort=users.employee_code&order=desc&page=2')
                    ->resize(900, 1600)
                    ->assertVisible('.fa.fa-sort-desc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('employee_code', 'desc')
                ->skip(10)->take(5)->get();

            $checkEmployeeCode = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmployeeCode = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(1)');
                $checkEmployeeCode = $borrowing->employee_code == $borrowingEmployeeCode;
                if (!$checkEmployeeCode) {
                    break;
                }
            }
            $this->assertTrue($checkEmployeeCode);
        });
    }

    /**
     * Test sort ASC Employee_code has pagination
     *
     * @return void
     */
    public function testSortEmployeeCodeASCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings?sort=users.employee_code&order=asc&page=2')
                    ->resize(900, 1600)
                    ->assertVisible('.fa.fa-sort-asc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('employee_code', 'asc')
                ->skip(10)->take(5)->get();

            $checkEmployeeCode = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmployeeCode = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(1)');
                $checkEmployeeCode = $borrowing->employee_code == $borrowingEmployeeCode;
                if (!$checkEmployeeCode) {
                    break;
                }
            }
            $this->assertTrue($checkEmployeeCode);
        });
    }

    /**
     * Test sort ASC Name has pagination
     *
     * @return void
     */
    public function testSortNameASCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings?sort=users.name&order=asc&page=2')
                    ->assertVisible('.fa.fa-sort-asc')
                    ->resize(900, 1600);
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('users.name', 'asc')
                ->skip(10)->take(5)->get();

            $checkName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingName = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $borrowing->users->name == $borrowingName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
     * Test sort DESC Name has pagination
     *
     * @return void
     */
    public function testSortNameDESCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings?sort=users.name&order=desc&page=2')
                    ->assertVisible('.fa.fa-sort-desc')
                    ->resize(900, 1600);
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('users.name', 'desc')
                ->skip(10)->take(5)->get();

            $checkName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingName = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $borrowing->users->name == $borrowingName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
     * Test sort DESC Name
     *
     * @return void
     */
    public function testSortNameDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings/')
                    ->resize(900, 1600)
                    ->clickLink('Name')
                    ->clickLink('Name')
                    ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('users.name', 'desc')
                ->limit(10)->get();

            $checkName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingName = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $borrowing->users->name == $borrowingName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
        * Test sort ASC Name
     *
     * @return void
     */
    public function testSortNameASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/borrowings/')
                    ->resize(900, 1600)
                    ->clickLink('Name')
                    ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('users.name', 'asc')
                ->limit(10)->get();

            $checkName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingName = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(2)');
                $checkName = $borrowing->users->name == $borrowingName;
                if (!$checkName) {
                    break;
                }
            }
            $this->assertTrue($checkName);
        });
    }

    /**
     * Test sort ASC Email
     *
     * @return void
     */
    public function testSortEmailASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('Email')
                ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('users.email', 'asc')
                ->limit(10)->get();

            $checkEmail = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmail = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkEmail = $borrowing->users->email == $borrowingEmail;
                if (!$checkEmail) {
                    break;
                }
            }
            $this->assertTrue($checkEmail);
        });
    }

    /**
     * Test sort DESC Email
     *
     * @return void
     */
    public function testSortEmailDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->resize(900, 1600)
                ->visit('/admin/borrowings/')
                ->clickLink('Email')
                ->clickLink('Email')
                ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('email', 'desc')
                ->limit(10)->get();

            $checkEmail = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmail = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkEmail = $borrowing->email == $borrowingEmail;
                if (!$checkEmail) {
                    break;
                }
            }
            $this->assertTrue($checkEmail);
        });
    }

    /**
     * Test sort DESC Email has pagination
     *
     * @return void
     */
    public function testSortEmailDESCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                ->resize(900, 1600)
                ->visit('/admin/borrowings?sort=users.email&order=desc&page=2')
                ->assertVisible('.fa.fa-sort-desc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('email', 'desc')
                ->skip(10)->take(5)->get();

            $checkEmail = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmail = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkEmail = $borrowing->email == $borrowingEmail;
                if (!$checkEmail) {
                    break;
                }
            }
            $this->assertTrue($checkEmail);
        });
    }

    /**
     * Test sort ASC Email has pagination
     *
     * @return void
     */
    public function testSortEmailASCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                ->resize(900, 1600)
                ->visit('/admin/borrowings?sort=users.email&order=asc&page=2')
                ->assertVisible('.fa.fa-sort-asc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('email', 'asc')
                ->skip(10)->take(5)->get();

            $checkEmail = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmail = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(3)');
                $checkEmail = $borrowing->email == $borrowingEmail;
                if (!$checkEmail) {
                    break;
                }
            }
            $this->assertTrue($checkEmail);
        });
    }

    /**
     * Test sort ASC Book
     *
     * @return void
     */
    public function testSortBookASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('Book')
                ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('books.name', 'asc')
                ->limit(10)->get();

            $checkBookName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingBook = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkBookName = $borrowing->books->name == $borrowingBook;
                if (!$checkBookName) {
                    break;
                }
            }
            $this->assertTrue($checkBookName);
        });
    }

    /**
     * Test sort DESC Book
     *
     * @return void
     */
    public function testSortBookDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('Book')
                ->clickLink('Book')
                ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('books.name', 'desc')
                ->limit(10)->get();

            $checkBookName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingBook = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkBookName = $borrowing->books->name == $borrowingBook;
                if (!$checkBookName) {
                    break;
                }
            }
            $this->assertTrue($checkBookName);
        });
    }

    /**
     * Test sort DESC Book has pagination
     *
     * @return void
     */
    public function testSortBookDESCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=books.name&order=desc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-desc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('books.name', 'desc')
                ->skip(10)->take(5)->get();

            $checkBookName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingBook = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkBookName = $borrowing->books->name == $borrowingBook;
                if (!$checkBookName) {
                    break;
                }
            }
            $this->assertTrue($checkBookName);
        });
    }

    /**
     * Test sort ASC Book has pagination
     *
     * @return void
     */
    public function testSortBookASCWithPagination()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=books.name&order=asc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-asc');
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('books.name', 'asc')
                ->skip(10)->take(5)->get();

            $checkBookName = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingBook = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(4)');
                $checkBookName = $borrowing->books->name == $borrowingBook;
                if (!$checkBookName) {
                    break;
                }
            }
            $this->assertTrue($checkBookName);
        });
    }

    /**
     * Test sort ASC FromDate
     *
     * @return void
     */
    public function testSortFromDateASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('From date')
                ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('from_date', 'asc')
                ->limit(10)->get();

            $checkFromDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingFromDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkFromDate = Carbon::parse($borrowing->from_date)->format('d-m-Y') == $borrowingFromDate;
                if (!$checkFromDate) {
                    break;
                }
            }
            $this->assertTrue($checkFromDate);
        });
    }

    /**
     * Test sort DESC FromDate
     *
     * @return void
     */
    public function testSortFromDateDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('From date')
                ->clickLink('From date')
                ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('from_date', 'desc')
                ->limit(10)->get();

            $checkFromDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingFromDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkFromDate = Carbon::parse($borrowing->from_date)->format('d-m-Y') == $borrowingFromDate;
                if (!$checkFromDate) {
                    break;
                }
            }
            $this->assertTrue($checkFromDate);
        });
    }

    /**
     * Test sort DESC FromDate has pagination
     *
     * @return void
     */
    public function testSortFromDateDESCWithPaginaiton()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=from_date&order=desc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('from_date', 'desc')
                ->skip(10)->take(5)->get();
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);

            $checkFromDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingFromDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkFromDate = Carbon::parse($borrowing->from_date)->format('d-m-Y') == $borrowingFromDate;
                if (!$checkFromDate) {
                    break;
                }
            }
            $this->assertTrue($checkFromDate);
        });
    }

 /**
     * Test sort ASC FromDate has pagination
     *
     * @return void
     */
    public function testSortFromDateASCWithPaginaiton()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=from_date&order=asc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('from_date', 'asc')
                ->skip(10)->take(5)->get();
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);

            $checkFromDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingFromDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(5)');
                $checkFromDate = Carbon::parse($borrowing->from_date)->format('d-m-Y') == $borrowingFromDate;
                if (!$checkFromDate) {
                    break;
                }
            }
            $this->assertTrue($checkFromDate);
        });
    }

    /**
     * Test sort ASC FromDate
     *
     * @return void
     */
    public function testSortEndDateASC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('End date')
                ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('to_date', 'asc')
                ->limit(10)->get();

            $checkToDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingToDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
                $checkToDate = Carbon::parse($borrowing->to_date)->format('d-m-Y') == $borrowingToDate;
                if (!$checkToDate) {
                    break;
                }
            }
            $this->assertTrue($checkToDate);
        });
    }

    /**
     * Test sort DESC FromDate
     *
     * @return void
     */
    public function testSortEndDateDESC()
    {
        $this->makeBorrowings(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings/')
                ->resize(900, 1600)
                ->clickLink('End date')
                ->clickLink('End date')
                ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('to_date', 'desc')
                ->limit(10)->get();

            $checkToDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingToDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
                $checkToDate = Carbon::parse($borrowing->to_date)->format('d-m-Y') == $borrowingToDate;
                if (!$checkToDate) {
                    break;
                }
            }
            $this->assertTrue($checkToDate);
        });
    }

    /**
     * Test sort DESC FromDate has pagination
     *
     * @return void
     */
    public function testSortEndDateDESCWithPaginaiton()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=to_date&order=desc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-desc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('to_date', 'desc')
                ->skip(10)->take(5)->get();
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);

            $checkToDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingToDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
                $checkToDate = Carbon::parse($borrowing->to_date)->format('d-m-Y') == $borrowingToDate;
                if (!$checkToDate) {
                    break;
                }
            }
            $this->assertTrue($checkToDate);
        });
    }

 /**
     * Test sort ASC FromDate has pagination
     *
     * @return void
     */
    public function testSortEndDateASCWithPaginaiton()
    {
        $this->makeBorrowings(14);
        $this->browse(function (Browser $browser) {
            $page = $browser->loginAs(User::find(1))
                            ->visit('/admin/borrowings?sort=to_date&order=asc&page=2')
                            ->resize(900, 1600)
                            ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::Join('users', 'borrowings.user_id', '=', 'users.id')
                ->Join('books', 'borrowings.book_id', '=', 'books.id')
                ->orderBy('to_date', 'asc')
                ->skip(10)->take(5)->get();
            $elements = $page->elements('#table-borrowings tbody tr');
            $this->assertCount(5, $elements);

            $checkToDate = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingToDate = $browser->text('#table-borrowings tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(6)');
                $checkToDate = Carbon::parse($borrowing->to_date)->format('d-m-Y') == $borrowingToDate;
                if (!$checkToDate) {
                    break;
                }
            }
            $this->assertTrue($checkToDate);
        });
    }

    /**
     * Create borrowings database
     *
     * @return void
     */
    public function makeBorrowings($rows)
    {
        $this->makeListOfBook(10);
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i=0; $i<= $rows; $i++){
            factory(Borrowing::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }
    }
}
