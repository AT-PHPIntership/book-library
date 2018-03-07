<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TopBookApiTest extends BaseTestBook
{
    use DatabaseMigrations;

    /**
     * Receive status code 200 when get list top book.
     *
     * @return void
     */
    public function testStatusCodeInTopBookBorrow()
    {
        $response = $this->get('/api/books/top-borrow');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureTopBorrowBooks(){
        return [
            'meta' => [
                'code',
                'message'
            ],
            'current_page',
            'data' => [
                    '*' => [
                        'name',
                        'borrowings_count'
                    ]
                ],
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
    public function testJsonTopBorrowStructure(){
        $this->makeListOfBook(1);
        $response = $this->json('GET', '/api/books/top-borrow');
        $response->assertJsonStructure($this->jsonStructureTopBorrowBooks());
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testWithPaginationTopBorrowBooks()
    {
        $this->makeListOfBook(21);
        $response = $this->json('GET', '/api/books/top-borrow' . '?page=2');
        $response->assertJson([
            'current_page' => 2,
            'per_page' => 20,
            'from' => 21,
            'to' => 21,
            'last_page' => 2,
            'next_page_url' => null,
        ]);
    }

    /**
     * Test structure of json when empty top books.
     *
     * @return void
     */
    public function testEmptyTopBorrowBooks(){
        $response = $this->json('GET', '/api/books/top-borrow');
        $response->assertJson([
            'data' => []
        ]);
    }
}
