<?php

namespace Tests\Browser;

use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Donator;
use Tests\DuskTestCase;
use App\Model\Category;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
                ->resize(1600, 2000)
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
                ->resize(1600, 2000)
                ->press('#2')
                ->waitForText('Do you want to delete this category?')
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
                ->pause(4000);
            $defaultCategoryBookCount = $browser->text('#table-categories tbody tr:nth-child(1) td:nth-child(3)');
            $categoryCount = $browser->text('.sidebar-menu li:nth-child(6) a .pull-right-container');
            $browser->press('OK')->pause(2000)
                    ->assertQueryStringHas('page', 2);
            $btnDelete = $browser->elements('#table-categories tbody tr');
            $totalRecord = Category::count();
            $browser->waitForText('Delete success')
                ->pause(5500)
                ->assertDontSee('Delete success');
            $this->assertCount($totalRecord % config('define.page_length'), $btnDelete);

            $browser->visit('/admin/categories')
                ->click('.pagination li:nth-child(3) a')
                ->pause(2000)
                ->press('#11')
                ->pause(2000)
                ->press('OK')
                ->pause(2000)
                ->assertQueryStringHas('page', 1);
            $newDefaultCategoryBookCount = $browser->text('#table-categories tbody tr:nth-child(1) td:nth-child(3)');
            $newCategoryCount = $browser->text('.sidebar-menu li:nth-child(6) a .pull-right-container');
            $this->assertTrue(($defaultCategoryBookCount + 2) == $newDefaultCategoryBookCount);
            $this->assertTrue(($categoryCount - 2) == $newCategoryCount);
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
     * Delete category already deleted
     * 
     * @return void
     */
    public function testDeleteDeletedCategory()
    {
        $deletedCategory = Category::findOrFail(2);
        $this->browse(function (Browser $browser) use ($deletedCategory) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1600, 2000)
                ->press('#2')
                ->pause(2000);
            $deletedCategory->delete();

            $browser->press('OK')
                ->pause(2000)
                ->assertSee('Category not found, please refresh page')
                ->waitUntilMissing('#delete-category-message');
        });
    }

    /**
     * Test delete default category
     * 
     * @return void
     */
    public function testDeleteDefaultCategory()
    {
        $category = Category::findOrFail(1);
        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'name' => $category->name,
        ]);
        
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1600, 2000)
                ->press('#2')
                ->pause(1000)
                ->script("$('.confirm').attr('data-id', 1)");
            $browser->press('OK')
                ->pause(1000)
                ->assertSee('You cannot delete this category, because it is a default category!');
        });

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'name' => $category->name,
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
        for ($i = 0, $length = 12; $i < $length; $i++) {
            $book = factory(Book::class, 1)->create([
                'category_id' => $categoryIds[$i],
                'donator_id' => $faker->randomElement($donatorIds),
                'image' => 'no-image.png',
            ]);
        }
    }


    /**
     * Adding user for testing
     * 
     * @return App\Model\User
     */
    public function fakeUser() {
        $user = [
            'employee_code' => 'AT0286',
            'name' => 'faker',
            'email' => 'faker',
            'team' => 'SA',
            'role' => 1,
        ];
        factory(User::class)->create($user);
        return $user = User::findOrFail(1);
    }
}
