<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Model\Category;
use App\Model\Book;
use App\Model\Donator;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Receive status code 200 when in tab top-borrow book.
     *
     * @return void
     */
    public function testStatusCodeWhenGetListBooks()
    {
        $response = $this->get('/api/books/top-borrow');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureOfBooks(){
        return [
            'data' => [
                [
                    'name',
                    'borrowings_count'
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
     * Test structure of json.
     *
     * @return void
     */
    public function testJsonStructure(){
        factory(Book::class)->create();
        $response = $this->json('GET', '/api/books/top-borrow');
        $response->assertJsonStructure($this->jsonStructureOfBooks());
    }

    /**
     * Test structure of json when empty categories.
     *
     * @return void
     */
//    public function testEmptyTopBorrowBooks(){
//        $response = $this->json('GET', '/api/books/top-borrow');
//        $response->assertJson([
//            'data' => []
//        ]);
//    }

    /**
     * Test compare database.
     *
     * @return void
     */
//    public function testCompareDatabase(){
//        factory(Book::class)->create(10);
//        $response = $this->json('GET', '/api/books/top-borrow');
//        $data = json_decode($response->getContent());
//        $this->assertDatabaseHas('books', [
//            'id' => $data->data[0]->id,
//            'name' => $data->data[0]->name,
//        ]);
//    }
}
