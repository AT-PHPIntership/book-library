<?php

namespace Tests\Browser\tests\Browser\Pages\BackEnd\Books;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SortBorrowingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeborrowings($rows)
    {
        $faker = Faker::create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds),
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, $rows)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        foreach ($userIds as $id) {
            factory(Borrowing::class, $rows)->create([
                'user_id' => $id,
                'book_id' => $faker->randomElement($categoryIds),
            ]);
        }
    }

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeUser()
    {
        factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }

    /**
     * Test sort ASC Employee_code
     *
     * @return void
     */
    public function testSortEmployeeCodeASC()
    {
        $this->userLogin();
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/borrowings')
                ->resize(900, 1600)
                ->assertVisible('.fa.fa-sort-asc');
            $borrowings = Borrowing::select('books.id', 'users.name')
                ->Join('borrowings', 'borrowings.book_id', '=', 'books.id')
                ->groupby('books.id')
                ->orderBy('borrowing', 'ASC')
                ->limit(10)->get();
            $checkEmployeeCode = false;
            foreach ($borrowings as $index => $borrowing) {
                $borrowingEmployeeCode = $browser->text('#table-book tbody tr:nth-child(' . (string)($index + 1) . ') td:nth-child(1)');
                $checkEmployeeCode = $borrowing->employee_code == $borrowingEmployeeCode;

                if (!$checkEmployeeCode) {
                    break;
                }
            }
            $this->assertTrue($checkEmployeeCodes);
        });
    }
}