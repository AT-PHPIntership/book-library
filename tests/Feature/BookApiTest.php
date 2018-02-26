<?php

namespace Tests\Feature;

use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use DB;

class BookApiTest extends BaseTestBook
{
    use DatabaseMigrations;

	/**
     * Test status code
     *
     * @return void
     */
    public function testStatusCodeListBooks()
    {
        $response = $this->get('/api/books');
        $response->assertStatus(Response::HTTP_OK);
    }
    
    /**
     * Return json structure of list books
     *
     * @return array
     */
    public function JsonStructureListBooks()
    {
        return [
            'data' => [
                [
                    'id',
                    'name',
                    'image',
                    'avg_rating'
                ]
            ],
            'meta' => [
                'message',
                'code'
            ],
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
     * Test compare structure of json.
     *
     * @return void
     */
    public function testJsonStructureListBooks()
    {
        $this->makeListOfBook(1);
        $response = $this->json('GET', '/api/books');
        $response->assertJsonStructure($this->JsonStructureListBooks());
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testWithPaginationListBooks()
    {
        $this->makeListOfBook(21);
        $response = $this->json('GET', '/api/books' . '?page=2');
        $response->assertJson([
            'current_page' => 2,
            'per_page' => 20,
            'from' => 21,
            'to' => 21,
            'last_page' => 2,
            'next_page_url' => null
        ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testCompareDatabaseListBooks()
    {
        $this->makeListOfBook(1);
        $response = $this->json('GET', '/api/books');
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('books', [
            'id' => $data->data[0]->id,
            'name' => $data->data[0]->name,
            'image' => $data->data[0]->image,
            'avg_rating' => $data->data[0]->avg_rating
        ]);
    }

    /**
     * Test structure of json when empty books.
     *
     * @return void
     */
    public function testEmptyBooks()
    {
        $response = $this->json('GET', '/api/books');
        $response->assertJson([
            'data' => []
        ]);
    }
}
