<?php

namespace Tests\Browser\Pages\Backend\Categories;

use App\Model\User;
use Tests\DuskTestCase;
use App\Model\Category;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminEditCategoriesTest extends BaseTestUser
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
    }

    /**
     * A test don't see edit button in list categories without data.
     *
     * @return void
     */
    public function testEditButtonInListCategoriesWithoutData()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->assertSee('List Categories')
                ->assertMissing('#table-categories .btn-show-edit-modal')
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
        $this->makeDataOfEditCategories(2);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->assertSee('List Categories')
                ->assertVisible('#table-categories .btn-show-edit-modal')
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
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->press('#table-categories #edit-modal1')
                ->pause(1000)
                ->assertSee('Rename Category')
                ->assertInputValue('#id-category', $category[0]->id)
                ->assertInputValue('#name-category', $category[0]->name)
                ->assertSeeIn('.btn-update-name-category', 'Update')
                ->assertSeeIn('.btn-close-update-category', 'Close');
        });
    }

    /**
     * A test edit name of category has already been taken..
     *
     * @return void
     */
    public function testEditNameCategoryAlreadyExists()
    {
        $category = $this->makeDataOfEditCategories(2);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->press('#table-categories .category2 #edit-modal2')
                ->pause(2000)
                ->type('name-category', $category[0]->name)
                ->pause(2000)
                ->press('.btn-update-name-category')
                ->pause(5000)
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
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->press('#table-categories .category1 #edit-modal1')
                ->pause(2000)
                ->type('name-category', '')
                ->pause(2000)
                ->press('.btn-update-name-category')
                ->pause(5000)
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
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->assertDontSee('New Category')
                ->press('#table-categories .category1  #edit-modal1')
                ->pause(2000)
                ->type('name-category', 'New Category')
                ->pause(2000)
                ->press('.btn-update-name-category')
                ->pause(5000)
                ->assertDontSee('Rename Category')
                ->assertSee('New Category');
            $this->assertDatabaseHas('categories', ['id' => $category[0]->id, 'name' => 'New Category']);
        });
    }

    /**
     * A test press edit button then press close.
     *
     * @return void
     */
    public function testPressEditThenClose()
    {
        $category = $this->makeDataOfEditCategories(1);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->adminUserToLogin)
                ->visit('/admin/categories')
                ->press('#table-categories .category1  #edit-modal1')
                ->pause(1000)
                ->press('.btn-close-update-category')
                ->pause(1000)
                ->assertDontSee('Rename Category')
                ->assertDontSeeIn('.btn-update-name-category', 'Update')
                ->assertDontSeeIn('.btn-close-update-category', 'Close');
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
