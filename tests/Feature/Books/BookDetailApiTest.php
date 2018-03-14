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
     * Test status code when connect api success.
     *
     * @return void
     */
    public function testStatusCodeConnectSuccess()
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
            'meta' => [
                'message',
                'code'
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
     * Test compare with database.
     *
     * @return void
     */
    public function testCompareDatabaseDetailsBook()
    {
        $this->makeData();
        $response = $this->json('GET', 'api/books/1');
        $datas = json_decode($response->getContent());
        $arrayCompareDetailsBook = [
            'name'              => $datas->data->name,
            'author'            => $datas->data->author,
            'year'              => $datas->data->year,
            'price'             => $datas->data->price,
            'number_of_pages'   => $datas->data->number_of_pages,
            'image'             => explode(request()->getSchemeAndHttpHost() . '/' . config('image.books.storage'), $datas->data->image)[1],
            'description'       => $datas->data->description,
            'avg_rating'        => $datas->data->avg_rating
        ];
        $this->assertDatabaseHas('books', $arrayCompareDetailsBook);
    }

    /**
     * Test status code fail
     *
     * @return void
     */
    public function testFailStatus()
    {
        $response = $this->json('GET', 'api/books/1');
        $response->assertJsonStructure([
            'meta' => [
                'message',
                'code'
            ],
        ]);
        $response->assertJson([
            'meta' => [
                'code'      => Response::HTTP_NOT_FOUND,
            ]
            
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
