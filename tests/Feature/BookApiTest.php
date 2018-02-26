<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\Borrowing;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;
use DB;

class BookApiTest extends TestCase
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
    public function testJsonStructureListBooks(){
        $this->makeData();
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
        $this->makeData();
        $response = $this->json('GET', '/api/books');
        $response->assertJson([
            'current_page' => 1,
            'per_page' => 20,
            'from' => 1,
            'to' => 20,
            'last_page' => 1
        
        ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testCompareDatabaseListBooks(){
        $this->makeData();
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
    public function testEmptyBooks(){
        $response = $this->json('GET', '/api/books');
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Create virtual database
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();
        
        factory(Category::class)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $userIds = DB::table('users')->pluck('id')->toArray();

        factory(Donator::class)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
    }
}
