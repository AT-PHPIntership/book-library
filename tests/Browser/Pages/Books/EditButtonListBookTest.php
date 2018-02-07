<?php

namespace Tests\Browser;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use App\Model\QrCode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EditButtonShowBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Create virtual listbook database.
     *
     * @return void
     */
    public function makeListOfBook($rows)
    {
        $faker = Faker::create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, $rows)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);

        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i = 0;$i <= 16; $i++) {
            factory(QrCode::class, 1)->create([
                'book_id' => $faker->randomElement($bookIds),
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }
    }

    /**
     * Create virtual user database.
     *
     * @return void
     */
    public function makeUser(){
        factory(User::class)->create([
            'role' => User::ROOT_ADMIN
        ]);
    }

    /**
     * Check page when click edit button.
     *
     * @return void
     */
    public function testClickEditButton()
    {
        $this->makeUser();
        $this->makeListOfBook(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/books')
                ->click('.btn-edit-1')
                ->assertPathIs('/admin/books/1/edit')
                ->assertSee('Edit Book')
                ->resize(1200, 900);
            $elements = $browser->elements('.form-group');
            $this->assertCount(8, $elements);
        });
    }

    /**
     * Check input form that show correct name of each label.
     *
     * @return void
     */
    public function testShowCorrectNameOfEachLabel()
    {
        $this->makeUser();
        $donator = factory(Donator::class)->create([
            'employee_code' => 'AT-0001',
        ]);
        $category = factory(Category::class)->create([
        ]);
        $book = factory(Book::class)->create([
            'category_id' => $category->first()->id,
            'donator_id' => $donator->id,
            'image' => 'no-image.png',
        ]);
        $this->browse(function (Browser $browser) use ($book) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/books/1/edit')
                ->assertSee('Edit Book')
                ->resize(900, 1600)
                ->screenshot('sample-screenshot');
            $browser->assertInputValue('name', $book->name)
                ->assertInputValue('author', $book->author)
                ->assertInputValue('price', $book->price)
                ->assertInputValue('year', $book->year)
                ->assertInputValue('employee_code','AT-0001')
                ->assertInputValue('description',$book->description)
                ->assertSourceHas('no-image.png');
        });
    }
}
