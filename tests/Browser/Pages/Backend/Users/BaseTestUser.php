<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;
use DB;

class BaseTestUser extends DuskTestCase
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
     * Make users.
     *
     * @param int $numberUser Number user.
     *
     * @return void
     */
    public function makeUser($numberUser)
    {
      factory(User::class, $numberUser)->create([
      ]);
      User::where('team', User::SA)->update(['role' => User::ROLE_ADMIN]);
    }

    /**
     * Random team but not "SA".
     *
     * @return string
     */
    public function teamNotSA()
    {
        $teamNotSA = [User::PHP, User::QC, User::ADROID, User::IOS];
        return $teamNotSA[array_rand($teamNotSA)];
    }
}
