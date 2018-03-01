<?php
namespace Tests\Feature\Books;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use App\Model\User;

class BookDetailApiTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Test status code.
     *
     * @return void
     */
    public function testStatusCodeApiDetailBook()
    {
        $this->makeData();
        $response = $this->json('GET', 'api/books/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test status code.
     *
     * @return void
     */
    public function testStructJsonApiDetailBook()
    {                                                                                                                                                                                                                                                                                                             
        $this->makeData();
        $response = $this->json('GET', 'api/books/1');
        $response->assertJsonStructure([                                                                                                                        
            "meta" => [
                "message",
                "code"
            ],                                                                                                                                                                                                                                                                                                                                                                                                                      
            'data' => [
                'name',
                'author',
                'year',
                'number_of_pages',
                'price',
                'image',
                'description',
                'avg_rating'
            ],
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test status code fail
     *
     * @return void
     */
    public function testFailStatus()
    {
        $response = $this->json('GET', 'api/books/1');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "meta" => [
                'message',
                "code"
            ],
        ]);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();

        factory(Book::class)->create([
            'category_id' => function () {
                return factory(Category::class)->create()->id;
            },
            'donator_id' => function () {
                return factory(Donator::class)->create()->id;
            },
            'name'      => $faker->name,
            'author'    => $faker->name,
            'year'      => $faker->year,
            'number_of_pages' => $faker->numberBetween(100, 1000),
            'price'     => $faker->numberBetween(1000, 10000),
            'image' => $faker->image($dir = '/tmp'),
            'description' => $faker->paragraph,
            'avg_rating' => $faker->numberBetween(1, 5),
        ]);
    }
}