<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryApiTest extends TestCase
{
    use DatabaseMigrations;
    
	/**
     * Receive status code 200 when get list categories.
     *
     * @return void
     */
    public function testStatusCodeWhenGetListCategories()
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(Response::HTTP_OK);
    }
}
