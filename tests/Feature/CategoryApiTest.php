<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;   

class CategoryApiTest extends TestCase
{
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
