<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Category;
use App\Model\Book;
use Faker\Factory as Faker;
use DB;
use App\Model\Donator;
use App\Model\User;

class DeleteCategoryTest extends DuskTestCase
{
    /**
     * Logged user
     * @var App\Model\User;
     */
    protected $user;

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->fakeUser();
        $this->fakeData();
    }

    /**
     * Testing delete category layout
     *
     * @return void
     */
    public function testAccessListCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->assertPathIs('/admin/categories')
                    ->assertVisible('.delete-category', 'background-color: #dd4b39');
        });
    }

    /**
     * Test show popup confirm
     * 
     * @return void
     */
    public function testShowPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->assertPathIs('/admin/categories')
                    ->press('#2')
                    ->pause(1000)
                    ->assertSee('Do you want to delete this category?')
                    ->assertSee('OK')
                    ->assertSee('Close');

            $browser->press('Close')
                    ->pause(1000)
                    ->assertDontSee('Do you want to delete this category?');
        });
    }

    /**
     * Test delete one category
     * 
     * @return void
     */
    public function testDeleteCategory()
    {
        $category = Category::offset(10)->limit(2)->get();

        $this->assertDatabaseHas('categories', [
            'id' => 11,
            'name' => $category[0]->name,
        ]);
        $this->assertDatabaseHas('categories', [
            'id' => 12,
            'name' => $category[1]->name,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1600, 2000)
                    ->click('.pagination li:nth-child(3) a')
                    ->press('#12')
                    ->pause(2000)
                    ->press('OK')->pause(2000)
                    ->assertQueryStringHas('page', 2);
            $btnDelete = $browser->elements('#table-categories tbody tr');
            $totalRecord = Category::count();
            $browser->pause(1000)
                    ->assertSee('Delete success')
                    ->pause(5500)
                    ->assertDontSee('Delete success');
            $this->assertCount($totalRecord % config('define.page_length'), $btnDelete);

            $browser->press('#11')
                    ->pause(2000)
                    ->press('OK')
                    ->pause(1000)
                    ->assertQueryStringHas('page', 1);
        });

        $this->assertDatabaseMissing('categories', [
            'id' => 11,
            'name' => $category[0]->name,
        ]);
        $this->assertDatabaseMissing('categories', [
            'id' => 12,
            'name' => $category[1]->name,
        ]);
    }

    /**
     * Fake data
     * 
     * @return void
     */
    public function fakeData()
    {
        $faker = Faker::create();
        factory(Category::class, 12)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $this->donators =  factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        $book = factory(Book::class, 10)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
            'image'      => 'no-image.png',
        ]);
    }


    /**
     * Adding user for testing
     * 
     * @return App\Model\User
     */
    public function fakeUser() {
        $user = [
            'employee_code' => 'AT0286',
            'name'          => 'faker',
            'email'         => 'faker',
            'team'          => 'SA',
            'role'          => 1,
        ];
        factory(User::class, 1)->create($user);
        return $user = User::findOrFail(1);
    }
}
