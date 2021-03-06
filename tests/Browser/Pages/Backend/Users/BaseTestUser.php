<?php

namespace Tests\Browser\Pages\Backend\Users;

use DB;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BaseTestUser extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make a user to login with team is "SA" and role is "Admin".
     *
     * @return User
     */
    public function makeUserTeamSA()
    {
        $user = factory(User::class)->create(['team' => User::SA, 'role' => User::ROLE_ADMIN]);
        return $user;
    }

    /**
     * Random team but not "SA".
     *
     * @return string
     */
    public function getTeamExceptSA()
    {
        $teamExceptSA = [User::PHP, User::QC, User::ANDROID, User::IOS];
        return $teamExceptSA[array_rand($teamExceptSA)];
    }

    /**
     * Make a user to login with role is "Admin".
     *
     * @return mixed
     */
    public function makeAdminUserToLogin()
    {
        return factory(User::class)->create([
            'role' => User::ROLE_ADMIN
        ]);
    }
}
