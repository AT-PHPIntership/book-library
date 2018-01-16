<?php

namespace Tests\Browser\Pages\Backend\Login;

use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Validation Admin Create News.
     *
     * @return void
     */
    // public function testValidationLogin()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->logout();
    //         $a = $browser->visit('login')
    //                 ->press('Login')
    //                 ->assertSee('The email field is required.')
    //                 ->assertSee('The password field is required.')
    //                 ->assertPathIs('/login');
    //     });
    // }

    
    public function testAdminLoginSuccess()
    {   
        $this->browse(function (Browser $browser)
        {
            factory(User::class, 1)->create([
                'email' => 'an.nguyen@asiantech.vn',
                'employee_code' => 'ATI0274',
                'role' => 1
            ]);
            $browser->logout();
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->assertPathIs('/login')
                    ->type('email', 'an.nguyen@asiantech.vn')
                    ->type('password', 'Annguyen735') 
                    ->press('Login')
                    ->assertSee('Admin Management')
                    ->assertPathIs('/admin');
        });
    }

    /**
     * Test Login success if account user.
     *
     * @return void
     */
    // public function testUserLoginSuccess()
    // {   
    //     $this->browse(function (Browser $browser)  {
    //         $browser->logout();
    //         $browser->visit('/login')
    //                 ->assertSee('Login')
    //                 ->assertPathIs('/login')
    //                 ->type('email', 'an.nguyen@asiantech.vn')
    //                 ->type('password', 'Annguyen735') 
    //                 ->press('Login')
    //                 ->assertPathIs('/');
    //     });
    // }

    /**
     * List case for Test Validation Login
     *
     */
    public function listCaseForTestLogin()
    {
        return [
            ['an@gmail.com', '', 'The password field is required.'],
            ['', '123123', 'The email field is required.'],
        ];
    }

    /**
     * Acount Login
     *
     */
    public function accountLogin()
    {
        return [
            ['an.nguyen@asiantech.vn', 'Annguyen735'],
        ];
    }

    /**
     * 
     * @dataProvider listCaseForTestLogin
     *
     */ 
    // public function testValidationEmailOrPassword($email, $password,$expected)
    // {   
    //     $this->browse(function (Browser $browser) use ($email, $password, $expected)
    //     {   
    //         $browser->logout();
    //         $browser->visit('/login')
    //             ->type('email', $email)
    //             ->type('password', $password)
    //             ->press('Login')
    //             ->assertSee($expected)
    //             ->assertPathIs('/login');
    //     });
    // }

    /**
     * Test Login failed.
     *
     * @return void
     */
    // public function testLoginFailed()
    // {   
    //     $this->browse(function (Browser $browser)
    //     {   
    //         $browser->logout();
    //         $browser->visit('/login')
    //             ->type('email', 'an@gmail.com')
    //             ->type('password', '123123')
    //             ->press('Login')
    //             ->assertSee('Email or password not correct')
    //             ->assertPathIs('/login');
    //     });
    // }
}
