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
use App\Model\Post;
use App\Model\Favorite;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookReviewTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->fakeData(2);
    }
    
    /**
     * Test http status code
     *
     * @return void
     */
    public function testStatusCodeBookReview()
    {
        $response = $this->json('GET', 'api/books/1/reviews');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test structure
     * 
     * @return void
     */
    public function testBookReviewJsonStructure()
    {
        $response = $this->json('GET', 'api/books/1/reviews');
        $response->assertJsonStructure([
            "meta" => [
                "code",
                "message"
            ],
            "current_page",
            "data" => [
                '*' => [
                    "id",
                    "content",
                    "type",
                    "name",
                    "team",
                    "favorites_count",
                ],
            ],
            "first_page_url",
            "from",
            "last_page",
            "last_page_url",
            "next_page_url",
            "path",
            "per_page",
            "prev_page_url",
            "to",
            "total"
        ]);
    }

    /**
     * Create data
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
        $userId = DB::table('users')->pluck('id')->toArray();
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(Post::class, 1)->create([
                'user_id' => $faker->randomElement($userId),
                'book_id' => $faker->randomElement($bookId)
            ]);
        }
        for ($i = 0; $i <= 25; $i++) {
            factory(Favorite::class, 1)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
    }

    /**
     * Test compare data get from api with database
     * 
     * @return void
     */
    public function testMatchDataReview()
    {
        $response = $this->json('GET', 'api/books/1/reviews');
        $apiData = json_decode($response->getContent());
        $postData = [
            "id" => $apiData->data[0]->id,
            "content" => $apiData->data[0]->content,
            "type" => $apiData->data[0]->type,
        ];
        $userData = [
            "name" => $apiData->data[0]->name,
            "team" => $apiData->data[0]->team
        ];
        $this->assertDatabaseHas('posts', $postData);
        $this->assertDatabaseHas('users', $userData);
    }
}
