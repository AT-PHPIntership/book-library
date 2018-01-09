<?php

namespace Tests\Browser\BackEnd;

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

class AdminEditBookTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testEditListButton()
    {
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $this->makeData();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $donatorId = DB::table('donators')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'donator_id' => $faker->randomElement($donatorId)
            ]);
        }
        $bookId = DB::table('books')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(Borrowing::class, 1)->create([
                'book_id' => $faker->randomElement($bookId),
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/books')
                ->resize(1200, 900)
                ->assertSee('LIST OF BOOK')
                ->click('#table-content tbody tr td .btn-edit-1');
        });
    }

    public function makeData()
    {
        DB::table('donators')->insert([
            ['user_id' => null,
                'employee_code' => 'AT-00011',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => '1',
                'employee_code' => '',
                'email' => 'a.nguyen@asiantech.vn',
            ],
            ['user_id' => '2',
                'employee_code' => '',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => '3',
                'employee_code' => '',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
                'employee_code' => 'AT-00015',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
                'employee_code' => 'AT-00008',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
            ['user_id' => null,
                'employee_code' => 'AT-00007',
                'email' => 'abc.nguyen@asiantech.vn',
            ],
        ]);
    }
}
