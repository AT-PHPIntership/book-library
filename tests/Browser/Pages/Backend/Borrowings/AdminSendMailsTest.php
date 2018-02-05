<?php

namespace Tests\Browser\Pages\Backend\Borrowings;

use DB;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Book;
use App\Model\Donator;
use Tests\DuskTestCase;
use App\Model\Category;
use App\Model\Borrowing;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminSendMailsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * make a User with admin role 
     *
     * @return void
     */
    public function makeAdminToLogin()
    {
        return factory(User::class)->create([
            'role' => User::ROLE_ADMIN,
        ]);
    }

    /**
     * Make data to test
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();

        for ($i = 1; $i <= $row; $i++) {
            factory(Category::class, 1)->create();
            factory(User::class, 1)->create();            
        }

        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        for($i = 1; $i <= $row; $i++) {
            $donator = factory(Donator::class, 1)->create([
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        for($i = 1; $i <= $row; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds),
            ]);
        }
        
        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i = 0; $i < $row; $i++) {
            factory(Borrowing::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }
    }

    /**
     * A Dusk test route to page list Borrowings.
     *
     * @return void
     */
    public function testRouteListBorrowings()
    {
        $user = $this->makeAdminToLogin();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/admin')
                    ->clickLink('BORROWS')
                    ->assertPathIs('/admin/borrowings')
                    ->assertSee('List Borrowers');
        });
    }

    /**
     * A Dusk test press button show pop-up confirm.
     *
     * @return void
     */
    public function testShowPopUpConfirm()
    {
        $user = $this->makeAdminToLogin();
        $this->makeData(10);
        $borrower = Borrowing::findOrFail(1);
        $this->browse(function (Browser $browser) use ($user, $borrower) {
            $browser->loginAs($user)
                    ->visit('/admin/borrowings')
                    ->resize(1600, 2000)
                    ->click('#1')
                    ->assertSee($borrower->users->name)
                    ->pause(1000)
                    ->assertSee('Confirm Send Mail');
        });
    }

    /**
     * A Dusk test success send mail.
     *
     * @return void
     */
    public function testPressOKButtonSuccess()
    {
        $user = $this->makeAdminToLogin();
        $this->makeData(10);
        $borrower = Borrowing::findOrFail(1);
        $this->browse(function (Browser $browser) use ($user, $borrower) {
            $browser->loginAs($user)
                    ->visit('/admin/borrowings')
                    ->resize(1600, 2000)
                    ->click('#1')
                    ->assertSee($borrower->users->name)
                    ->pause(1000)
                    ->assertSee('Confirm Send Mail')
                    ->press('OK')
                    ->pause(3000)                    
                    ->assertSee('Send Mail Success');
        });
    }

    /**
     * A Dusk test cacle send mail.
     *
     * @return void
     */
    public function testPressCloseButton()
    {
        $user = $this->makeAdminToLogin();
        $this->makeData(10);
        $borrower = Borrowing::findOrFail(1);
        $this->browse(function (Browser $browser) use ($user, $borrower) {
            $browser->loginAs($user)
                    ->visit('/admin/borrowings')
                    ->resize(1600, 2000)
                    ->click('#1')
                    ->assertSee($borrower->users->name)
                    ->pause(1000)                    
                    ->assertSee('Confirm Send Mail')
                    ->press('Close')
                    ->pause(1000)                    
                    ->assertDontSee('Confirm Send Mail');
        });
    }
}
