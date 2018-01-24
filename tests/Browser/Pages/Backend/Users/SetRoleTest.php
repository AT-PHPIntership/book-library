<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\User;
use Faker\Factory as Faker;

class SetRoleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make a user to login from $userLogin.
     *
     * @param array $userLogin If $userLogin has a name or role, $user has a name or role like $userLogin,
     * otherwise random to get name and role.
     *
     * @return App\Model\User
     */
    public function makeUserLogin($userLogin)
    {
        $user = factory(User::class)->create($userLogin);
        return $user;
    }

    /**
     * Make 10 users.
     *
     * @return void
     */
    public function makeUser()
    {
      factory(User::class, 10)->create([
      ]);
      User::where('team', User::SA)->update(['role' => User::ROLE_ADMIN]);
    }

    /**
     * If role of user was logining is User, move to /login with message
     *
     * @return void
     */
    public function testNotRoleAdmin()
    {
        $this->makeUser();
        $userLogin['role'] = User::ROLE_USER;
        $user = new User();
        $user = $this->makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertPathIs('/login')
                    ->assertSee('You are NOT an Administrator');
        });
    }

    /**
     * If user was logining has role = 1 but team not SA, it can't see column Role.
     *
     * @return void
     */
    public function testRoleAdminNotTeamSA()
    {
        $this->makeUser();
        $teamNotSA = [User::PHP, User::QC, User::ADROID, User::IOS];
        $userLogin['team'] = $teamNotSA[array_rand($teamNotSA)];
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = $this->makeUserLogin($userLogin);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->resize(1200, 900)
                    ->visit('/admin/users')
                    ->assertSee('List Users')
                    ->assertDontSee('Role');
        });
    }

    /**
     * If user was logining has role = 1 and team is SA, it can see column Role.
     *
     * @return void
     */
    public function testRoleAdminTeamSA()
    {
        $this->makeUser();
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = $this->makeUserLogin($userLogin);
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
        $this->makeUser();
        $teamNotSA = [User::PHP, User::QC, User::ADROID, User::IOS];
        User::first()->update(['role' => User::ROLE_USER, 'team' => $teamNotSA[array_rand($teamNotSA)]]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = $this->makeUserLogin($userLogin);
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
        $this->makeUser();
        $teamNotSA = [User::PHP, User::QC, User::ADROID, User::IOS];
        User::first()->update(['role' => User::ROLE_ADMIN, 'team' => $teamNotSA[array_rand($teamNotSA)]]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = $this->makeUserLogin($userLogin);
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
     * Can't change role of User of SA team, button update is disabled and do nothing when press.
     *
     * @return void
     */
    public function testUpdateRoleOfAdminTeamSA()
    {
        $this->makeUser();
        User::first()->update(['role' => User::ROLE_ADMIN, 'team' => User::SA]);
        $userLogin['team'] = User::SA;
        $userLogin['role'] = User::ROLE_ADMIN;
        $user = $this->makeUserLogin($userLogin);
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
