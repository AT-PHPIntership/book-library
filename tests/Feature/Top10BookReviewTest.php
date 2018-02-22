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

class Top10BookReviewTest extends TestCase
{
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
        $response->assertStatus(200);
    }

    public function testJsonStructure()
    {
        $response = $this->json('GET', 'api/books/top-review');
        $response->assertJsonStructure([
            "meta" => [
                "status",
                "code"
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
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 1)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        $book = factory(Book::class, $totalBook)->create([
            'category_id' => $faker->randomElement([
                '1' => 2,
                '2' => 3
            ]),
            'donator_id' => $faker->randomElement($donatorIds),
            'image'      => 'no-image.png',
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
        $bookData = [
            'name' => $apiData->data[0]->name,
            'image' => substr(($apiData->data[0]->image), strlen(request()->getHttpHost()) + 1),
            'avg_rating' => $apiData->data[0]->avg_rating,
        ];
        $this->assertDatabaseHas('books', $bookData);
    }
}
