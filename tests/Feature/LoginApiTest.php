<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Model\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test login api.
     *
     * @return void
     */
    public function testLoginAPI()
    {
        Mockery::mock('\App\Http\Controllers\Api\LoginController')
           ->shouldReceive('login')
           ->andReturn($this->jsonStructureLoginFail())
           ->andReturn($this->jsonStructureLoginSuccess())
           ->atLeast();
    }

    /**
     * Return json structure of login user success
     *
     * @return array
     */
    public function jsonStructureLoginSuccess()
    {
        return [
            "meta" => [
                "message",
                "code"
            ],
            "data" => [
                "id",
                "employee_code",
                "name",
                "email",
                "team",
                "avatar_url",
                "role",
                "access_token",
                "created_at",
                "updated_at",
                "deleted_at"
            ]
        ];
    }

    /**
     * Return json structure of login user fail
     *
     * @return array
     */
    public function jsonStructureLoginFail()
    {
        return [
            "meta" => [
                "message",
                "code"
            ]
        ];
    }
}
