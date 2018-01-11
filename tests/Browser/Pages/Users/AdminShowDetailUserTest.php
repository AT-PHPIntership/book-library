<?php

namespace Tests\Browser;

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
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/users')
                ->assertSee('List Users')
                ->click('@href-detailpage')
                ->assertSee('Profile User');
        });
    }

    /**
     * Test Route View Admin Show User Page.
     *
     * @return void
     */
    public function testShowUser()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/users/' . $user->employee_code)
                ->assertSee($user->name)
                ->assertSee($user->email);
        });
    }
}
