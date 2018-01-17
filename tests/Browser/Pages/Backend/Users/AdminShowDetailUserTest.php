<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminShowDetailUserTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A User with role 1 test example.
     *
     * @return void
     */
    public function userLogin()
    {
        factory(User::class, 1)->create([
            'role' => '1', 
        ]);
    }

    /**
     * Test route view admin show detail user.
     *
     * @return void
     */
    public function testRouteShowDetailUser()
    {          
            $this->userLogin();
            $user = User::find(1);
            $this->browse(function (Browser $browser) use ($user) {
                $browser->loginAs($user)
                    ->visit('/admin/users')
                    ->assertSee('List Users')
                    ->click('.username')
                    ->visit('admin/users/'.$user->employee_code)
                    ->assertSee('Profile User');
            });
    }
    
    /**
     * Test layout of detail User Page.
     *
     * @return void
     */
    public function testLayoutDetailUser()
    {
        $this->userLogin();
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/users/' . $user->employee_code)
                ->assertSee('Profile User')
                ->assertSee('Follow')
                ->assertSee('Borrowed')
                ->assertSee('Donated')
                ->assertSee('Borrowing')
                ->assertSee('About')
                ->assertSee('fullname')
                ->assertSee('join_dated')
                ->assertSee('email');
        });
    }

    /**
     * Test Route View Admin Show User Page.
     *
     * @return void
     */
    public function testShowDetailUser()
    {
        $this->userLogin();
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/users/' . $user->employee_code)
                ->assertSee($user->name)
                ->assertSee($user->email);
        });
    }
}
