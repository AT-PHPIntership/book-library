<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\User;
use Faker\Factory as Faker;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;

class SetRoleTest extends BaseTestUser
{
    use DatabaseMigrations;

    /**
     * If role of user was logining is "User", move to "/login" with message.
     *
     * @return void
     */
    public function testLoginAdminPageWithUserAccount()
    {
        $userLogin = factory(User::class)->create(['role' => User::ROLE_USER]);
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertPathIs('/login')
                    ->assertSee('You are NOT an Administrator');
        });
    }

    /**
     * If user was logining has role "Admin" but team not "SA", it can't see column "Role".
     *
     * @return void
     */
    public function testAdminAccountNotBelongsToSATeam()
    {
        $userLogin = factory(User::class)->create(['team' => $this->getTeamExceptSA(), 'role' => User::ROLE_ADMIN]);
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSee('List Users')
                    ->assertDontSee('Role');
        });
    }

    /**
     * If user was logining has role "Admin" and team is "SA", it can see column "Role".
     *
     * @return void
     */
    public function testAdminAccountBelongsToSATeam()
    {
        $userLogin = $this->makeUserTeamSA();
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSee('List Users')
                    ->assertSee('Role');
        });
    }

    /**
     * When update role of User, button has color "red" and value "User" change to button has color "green" and value "Admin".
     *
     * @return void
     */
    public function testUpdateRoleOfUser()
    {
        $user = factory(User::class)->create(['team' => $this->getTeamExceptSA(), 'role' => User::ROLE_USER]);
        $userLogin = $this->makeUserTeamSA();
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSeeIn('#role-1', 'User')
                    ->assertVisible('#role-1', 'background-color: #d73925')
                    ->press('#role-1')
                    ->pause(3000)
                    ->assertSeeIn('#role-1', 'Admin')
                    ->assertVisible('#role-1', 'background-color: #00a65a'); 
        });
    }

    /**
     * When update role of Admin, button has color "green" and value "Admin" change to button has color "red" and value "User".
     *
     * @return void
     */
    public function testUpdateRoleOfAdminNotTeamSA()
    {
        $user = factory(User::class)->create(['team' => $this->getTeamExceptSA(), 'role' => User::ROLE_ADMIN]);
        $userLogin = $this->makeUserTeamSA();
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSeeIn('#role-1', 'Admin')
                    ->assertVisible('#role-1', 'background-color: #00a65a')
                    ->press('#role-1')
                    ->pause(3000)
                    ->assertSeeIn('#role-1', 'User')
                    ->assertVisible('#role-1', 'background-color: #d73925');
        });
    }

    /**
     * Can't change role of User of team "SA", button update is disabled and do nothing when press.
     *
     * @return void
     */
    public function testUpdateRoleOfAdminTeamSA()
    {
        $user = $this->makeUserTeamSA();
        $userLogin  = $this->makeUserTeamSA();
        $this->browse(function (Browser $browser) use ($userLogin) {
            $browser->loginAs($userLogin)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSeeIn('#role-1', 'Admin')
                    ->assertVisible('#role-1', 'background-color: #00a65a')
                    ->assertVisible('#role-1', 'disabled')
                    ->press('#role-1')
                    ->pause(1000)
                    ->assertSeeIn('#role-1', 'Admin')
                    ->assertVisible('#role-1', 'background-color: #00a65a')
                    ->assertVisible('#role-1', 'disabled');
        });
    }
}
