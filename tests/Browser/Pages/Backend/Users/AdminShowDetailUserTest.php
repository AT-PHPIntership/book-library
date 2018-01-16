<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\User;

class AdminShowDetailUserTest extends DuskTestCase
{

    /**
     * Test route view admin show detail user.
     *
     * @return void
     */
    public function testRouteShowDetailUser()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/users')
                ->click('#username')
                ->assertPathIs('/admin/users/' . $user->employee_code);
        });
    }

    /**
     * Test layout of detail User Page.
     *
     * @return void
     */
    public function testLayoutDetailUser()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/users/' . $user->employee_code)
                ->assertSee('Profile User')
                ->assertSee('About');
        });
    }

    /**
     * Test Route View Admin Show User Page.
     *
     * @return void
     */
    public function testShowDetailUser()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/users/' . $user->employee_code)
                ->assertSee($user->name)
                ->assertSee($user->email);
        });
    }
}
