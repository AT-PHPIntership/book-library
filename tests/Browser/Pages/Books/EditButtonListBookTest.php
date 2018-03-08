<?php

namespace Tests\Browser;

use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EditButtonShowBookTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * Create user with role "Admin".
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create(['role' => User::ROLE_ADMIN]);
    }

    /**
     * Check page when click edit button.
     *
     * @return void
     */
    public function testClickEditButton()
    {
        $this->makeListOfBook(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/books')
                ->click('.btn-edit-1')
                ->assertPathIs('/admin/books/1/edit')
                ->assertSee('Edit Book')
                ->resize(1200, 900);
            $elements = $browser->elements('.form-group');
            $this->assertCount(10, $elements);
        });
    }

    /**
     * Check input form that show correct name of each label.
     *
     * @return void
     */
    public function testShowCorrectNameOfEachLabel()
    {
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
                ->resize(900, 1600);
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
