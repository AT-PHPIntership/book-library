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
     * Make a user to login with team is "SA" and role is "Admin".
     *
     * @return App\Model\User
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
    public function teamNotSA()
    {
        $teamNotSA = [User::PHP, User::QC, User::ANDROID, User::IOS];
        return $teamNotSA[array_rand($teamNotSA)];
    }
}
