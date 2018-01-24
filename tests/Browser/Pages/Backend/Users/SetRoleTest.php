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
     * Make 10 users.
     *
     * @return void
     */
    // public function makeUser()
    // {
    //   factory(User::class, 10)->create([
    //   ]);
    //   User::where('team', User::SA)->update(['role' => User::ROLE_ADMIN]);
    // }

    /**
     * If role of user was logining is "User", move to "/login" with message.
     *
     * @return void
     */
    public function testNotRoleAdmin()
    {
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        $userLogin['role'] = User::ROLE_USER;
        $user = new User();
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
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
    public function testRoleAdminNotTeamSA()
    {
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        $userLogin = ['team' => BaseTestUser::teamNotSA(), 'role' => User::ROLE_ADMIN];
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
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
    public function testRoleAdminTeamSA()
    {
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        $userLogin = ['team' => User::SA, 'role' => User::ROLE_ADMIN];
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
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
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        User::first()->update(['team' => BaseTestUser::teamNotSA(), 'role' => User::ROLE_USER]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSeeIn('#role-1', 'User')
                    ->assertVisible('#role-1', 'background-color: #d73925')
                    ->press('#role-1')
                    ->pause(1000)
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
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        User::first()->update(['team' => BaseTestUser::teamNotSA(), 'role' => User::ROLE_ADMIN]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSeeIn('#role-1', 'Admin')
                    ->assertVisible('#role-1', 'background-color: #00a65a')
                    ->press('#role-1')
                    ->pause(1000)
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
        $numberUser = 15;
        BaseTestUser::makeUser($numberUser);
        User::first()->update(['team' => User::SA, 'role' => User::ROLE_ADMIN]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = BaseTestUser::makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
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
