<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Model\Category;
use Faker\Factory as Faker;
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

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureOfCategories(){
        return [
            'data' => [
                [
                    'id',
                    'name',
                    'books_count'
                ]
            ],
            'success',
            'current_page',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ];
    }

    /**
     * Test structure of json.
     *
     * @return void
     */
    public function testJsonStructure(){
        factory(Category::class)->create();
        $response = $this->json('GET', '/api/categories');
        $response->assertJsonStructure($this->jsonStructureOfCategories());
    }

    /**
     * Test structure of json when empty categories.
     *
     * @return void
     */
    public function testEmptyCategories(){
        $response = $this->json('GET', '/api/categories');
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testCompareDatabase(){
        factory(Category::class)->create();
        $response = $this->json('GET', '/api/categories');
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('categories', [
            'id' => $data->data[0]->id,
            'name' => $data->data[0]->name,
        ]);
    }
}
