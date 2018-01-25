<?php

namespace Tests\Browser\Pages\Backend\Categories;

use App\Model\Book;
use App\Model\Category;
use App\Model\User;
use App\Model\Donator;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminListCategoriesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * make a User with role 1.
     *
     * @return void
     */
    public function makeUser(){
        factory(User::class)->create([
            'role' => 1
        ]);
    }


    /**
     * A Dusk test route to page list categories.
     *
     * @return void
     */
    public function testRouteShowListCategories()
    {
        $this->makeUser();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->clickLink('CATEGORIES')
                    ->assertPathIs('/admin/categories')
                    ->assertSee('List Categories');
        });
    }

    /**
     * Test layout of List Categories.
     *
     * @return void
     */
    public function testLayoutListCategories()
    {
        $this->makeUser();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->assertSee('List Categories')
                ->assertSeeLink('Admin')
                ->assertSee('ID')
                ->assertSee('Name')
                ->assertSee('Number of Books');
        });
    }

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeDataOfListCategories($rows)
    {
        $faker = Faker::create();

        factory(Category::class, $rows)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $donator = factory(Donator::class, 1)->create();

        for ($i = 0; $i <= $rows; $i++)
        {
            factory(Book::class,1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => 1,
                'name' => $faker->sentence(rand(2,5)),
                'author' => $faker->name,
            ]);
        }
    }

    /**
     * Check the list of categories without data
     *
     * @return void
     */
    public function testShowListCategoriesNoData()
    {
        $this->makeUser();
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/categories/')
                ->resize(900, 1600)
                ->assertSee('List Categories');
                $elements = $browser->elements('#table-categories tbody tr');
                $this->assertCount(0, $elements);
        });
    }

    /**
     * Check list categories with showing only 10 rows
     *
     * @return void
     */
    public function testShowListCategoriesNoPagination()
    {
        $this->makeUser();
        $this->makeDataOfListCategories(8);
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/categories/')
                ->resize(900, 1600)
                ->assertSee('List Categories');
                $elements = $browser->elements('#table-categories tbody tr');
                $this->assertCount(8, $elements);
        });
    }

    /**
     * A Dusk test Pagination
     *
     * @return void
     */
    public function testPagination()
    {
        $this->makeUser();
        $this->makeDataOfListCategories(25);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories/')
                    ->resize(900, 1600)
                    ->assertSee('List Categories');
            $elements = $browser->elements('.pagination li');
            $numberPage = count($elements) - 2;
            $this->assertTrue($numberPage == ceil(25 / (config('define.page_length'))));
        });
    }

    /**
     * Check list categories with showing than 10 rows
     *
     * @return void
     */
    public function testShowListCategoriesHavePagination()
    {
        $this->makeUser();
        $this->makeDataOfListCategories(15);
        $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
                ->visit('/admin/categories/')
                ->resize(900, 1600)
                ->assertSee('List Categories')
                ->click('.pagination li:nth-child(3) a');
                $elements = $browser->elements('#table-categories tbody tr');
                $this->assertCount(5, $elements);
                $browser->assertQueryStringHas('page', 2);
                $this->assertNotNull($browser->element('.pagination'));
        });
    }
}
