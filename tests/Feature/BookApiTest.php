<?php

namespace Tests\Feature;

use App\Model\Book;
use Illuminate\Http\Response;
use Tests\Browser\Pages\Backend\Books\BaseTestBook;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
    public function jsonStructureListBooks()
    {
        return [
            'data' => [
                [
                    'id',
                    'name',
                    'author',
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
        $response->assertJsonStructure($this->jsonStructureListBooks());
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
            'author' => $data->data[0]->author,
            'image' => explode(request()->getSchemeAndHttpHost() . '/' . config('image.books.storage'), $data->data[0]->image)[1],
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

    /**
     * Test search books with correct name.
     *
     * @return void
     */
    public function testSearchBookCorrectName()
    {
        $this->makeListOfBook(1);
        $book = Book::first();
        $response = $this->json('GET', '/api/books?search='. $book->name);
        $response->assertJson([
            'data' => [
                [
                    'id' => $book->id,
                    'name' => $book->name,
                    'author' => $book->author,
                    'image' => $book->image,
                    'avg_rating' => $book->avg_rating
                ]
            ]
        ]);
    }

    /**
     * Test search books with correct author.
     *
     * @return void
     */
    public function testSearchBookCorrectAuthor()
    {
        $this->makeListOfBook(1);
        $book = Book::first();
        $response = $this->json('GET', '/api/books?search='. $book->author);
        $response->assertJson([
            'data' => [
                [
                    'id' => $book->id,
                    'name' => $book->name,
                    'author' => $book->author,
                    'image' => $book->image,
                    'avg_rating' => $book->avg_rating
                ]
            ]
        ]);
    }

    /**
     * Test search books with correct name and author.
     *
     * @return void
     */
    public function testSearchBookCorrectNameAndAuthor()
    {
        $this->makeListOfBook(2);
        Book::where('id', 1)->update(['name' => '0']);
        Book::where('id', 2)->update(['author' => '0']);
        $response = $this->json('GET', '/api/books?search=0');
        $response->assertJson([
            'data' => [
                [
                    'name' => '0'
                ],
                [
                    'author' => '0'
                ]
            ]
        ]);
    }

    /**
     * Test search books with incorrect keyword.
     *
     * @return void
     */
    public function testSearchBookIncorrectKeyword()
    {
        $this->makeListOfBook(10);
        Book::select('*')->update(['name' => '1', 'author' => '1']);
        $response = $this->json('GET', '/api/books?search=0');
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Test search books without keyword.
     *
     * @return void
     */
    public function testSearchBookWithoutKeyword()
    {
        $this->makeListOfBook(10);
        $response = $this->json('GET', '/api/books?search=');
        $content = json_decode($response->getContent());
        $this->assertTrue(sizeof($content->data) === 10);
    }
}
