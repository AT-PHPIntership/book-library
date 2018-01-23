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
        return factory(User::class)->create([
            'role' => '1',
            'avatar_url' => 'http://127.0.0.1/images/user/avatar/avatar-default.png',
        ]);
    }

    /**
     * Test route view admin show detail user.
     *
     * @return void
     */
    public function testRouteShowDetailUser()
    {          
        $user = $this->userLogin();
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
        $user = $this->userLogin();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/users/' . $user->employee_code)
                ->assertSee('Profile User')
                ->assertSee('Borrowed')
                ->assertSee('Donated')
                ->assertSee('Borrowing')
                ->assertSee('About')
                ->assertSee('Full Name')
                ->assertSee('Join Dated')
                ->assertSee('Team')
                ->assertSee('Email');
        });
    }

    /**
     * Test Route View Admin Show User Page.
     *
     * @return void
     */
    public function testShowDetailUser()
    {
        $user = $this->userLogin();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/users/' . $user->employee_code);
                $this->assertTrue($browser->text('.username') === $user->name);
                $this->assertTrue($browser->text('.email') === $user->email);
                $this->assertTrue($browser->text('.join_date') === date('d-m-Y', strtotime($user->created_at)));
                $browser->assertSourceHas('http://127.0.0.1/images/user/avatar/avatar-default.png');
        });
    }
}
