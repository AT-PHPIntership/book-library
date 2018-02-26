<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Book;
use Faker\Factory as Faker;
use DB;
use App\Model\Donator;
use App\Model\Category;
use App\Model\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Top10BookReviewTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->fakeData(2);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', 'api/books/top-review');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testJsonStructure()
    {
        $response = $this->json('GET', 'api/books/top-review');
        $response->assertJsonStructure([
            "meta" => [
                "code",
                "message"
            ],
            "data" => [
                [
                    "name",
                    "image",
                    "avg_rating",
                    "posts_count"
                ]
            ]
        ]);
    }

    /**
     * Fake data testing
     * 
     * @return void
     */
    public function fakeData($totalBook)
    {
        $faker = Faker::create();
        factory(Category::class, 3)->create();
        factory(User::class, 1)->create();
        DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 1)->create();
        DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, $totalBook)->create([
            'category_id' => $faker->randomElement([
                '1' => 2,
                '2' => 3
            ]),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
    }

    /**
     * Test compare data get from api with database
     * 
     * @return void
     */
    public function testMatchData()
    {
        $response = $this->json('GET', 'api/books/top-review');
        $apiData = json_decode($response->getContent());
        $imagePath = explode(request()->getSchemeAndHttpHost() . '/' . config('image.books.storage'), $apiData->data[0]->image)[1];
        $bookData = [
            'name' => $apiData->data[0]->name,
            'image' => $imagePath,
            'avg_rating' => $apiData->data[0]->avg_rating,
        ];
        $this->assertDatabaseHas('books', $bookData);
    }
}
