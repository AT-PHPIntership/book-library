<?php

namespace Tests\Browser\Pages\Backend\Categories;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;

class AdminEditCategoriesTest extends BaseTestUser
{
    use DatabaseMigrations;

    /**
     * A test don't see edit button in list categories without data.
     *
     * @return void
     */
    public function testEditButtonInListCategoriesWithoutData()
    {
        $admin  = $this->makeAdminUserToLogin();
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->assertSee('List Categories')
                    ->assertMissing('#table-categories #edit-modal1');
        });
    }

    /**
     * A test see edit button in list categories have data.
     *
     * @return void
     */
    public function testSeeEditButtonInListCategoriesHaveData()
    {
        $admin  = $this->makeAdminUserToLogin();
        $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->assertSee('List Categories')
                    ->assertVisible('#table-categories #edit-modal1');
        });
    }

    /**
     * A test edit button work right.
     *
     * @return void
     */
    public function testEditButtonWorkRight()
    {
        $admin  = $this->makeAdminUserToLogin();
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($admin,$category) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->press('#table-categories #edit-modal1')
                    ->assertSee('Rename Category')
                    ->assertInputValue('#idCategory', $category[0]->id)
                    ->assertInputValue('#nameCategory', $category[0]->name)
                    ->assertSeeIn('.update', 'Update')
                    ->assertSeeIn('.closebtn', 'Close');
        });
    }

    /**
     * A test edit name of category has already been taken..
     *
     * @return void
     */
    public function testEditNameCategoryAlreadyExists()
    {
        $admin  = $this->makeAdminUserToLogin();
        $category = $this->makeDataOfEditCategories(2);
        $this->browse(function (Browser $browser) use ($admin,$category) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->press('#table-categories .category2 #edit-modal2')
                    ->type('input[type=name]',$category[0]->name)
                    ->press('.update')
                    ->pause(1000)
                    ->assertSee('The name has already been taken.');
        });    
    }

    /**
     * A test edit name of category has already been taken..
     *
     * @return void
     */
    public function testEditNameCategoryToEmpty()
    {
        $admin  = $this->makeAdminUserToLogin();
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($admin,$category) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->press('#table-categories .category1 #edit-modal1')
                    ->type('input[type=name]','')
                    ->press('.update')
                    ->pause(1000)
                    ->assertSee('The name field is required.');
        });    
    }

    /**
     * A test edit the name successfully.
     *
     * @return void
     */
    public function testEditNameCategorySuccessfully()
    {
        $admin  = $this->makeAdminUserToLogin();
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($admin,$category) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->assertDontSee('New Category')
                    ->press('#table-categories .category1  #edit-modal1')
                    ->type('input[type=name]','New Category')
                    ->press('.editCategory')
                    ->pause(2000)
                    ->assertDontSee('Rename Category')
                    ->assertSee('New Category');
            $this->assertDatabaseHas('categories', ['id' => $category[0]->id,'name' => 'New Category']);
        });
    }

    /**
     * A test press edit button then press close.
     *
     * @return void
     */
    public function testPressEditThenClose()
    {
        $admin  = $this->makeAdminUserToLogin();
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($admin,$category) {
            $browser->loginAs($admin)
                    ->visit('/admin/categories')
                    ->press('#table-categories .category1  #edit-modal1')
                    ->press('.closebtn')
                    ->pause(1000)
                    ->assertDontSee('Rename Category');
        });
    }

    /**
     * Create virtual data to test
     *
     * @return void
     */
    public function makeDataOfEditCategories($rows)
    {
        return factory(Category::class, $rows)->create();
    }
}
