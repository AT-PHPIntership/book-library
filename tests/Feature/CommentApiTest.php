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
use App\Model\Comment;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->makeData(2);
    }
    
    /**
     * Test http status code
     *
     * @return void
     */
    public function testStatusCodePostParentComment()
    {
        $response = $this->json('GET', 'api/posts/1/comments');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test http status code
     *
     * @return void
     */
    public function testStatusCodeChildComment()
    {
        $response = $this->json('GET', 'api/comments/1/child-comments');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test structure
     * 
     * @return void
     */
    public function testCommentJsonStructure()
    {
        $parentCommentResponse = $this->json('GET', 'api/posts/1/comments');
        $this->generalCheckCommentJsonStructure($parentCommentResponse);
        
        $childCommentResponse = $this->json('GET', 'api/comments/1/child-comments');
        $this->generalCheckCommentJsonStructure($childCommentResponse);
    }

    public function generalCheckCommentJsonStructure($response)
    {
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
                    "created_at",
                    "name",
                    "team",
                    "avatar_url",
                    "favorites_count"
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
     * Test compare data get from api with database
     * 
     * @return void
     */
    public function testMatchDataComment()
    {
        $parentCommentResponse = $this->json('GET', 'api/posts/1/comments');
        $this->generalCheckData($parentCommentResponse);

        $childCommentResponse = $this->json('GET', 'api/comments/1/child-comments');
        $this->generalCheckData($childCommentResponse);
    }

    public function generalCheckData($response)
    {
        $apiData = json_decode($response->getContent());
        $postData = [
            "id" => $apiData->data[0]->id,
            "content" => $apiData->data[0]->content,
            "created_at" => $apiData->data[0]->created_at,
        ];
        $userData = [
            "name" => $apiData->data[0]->name,
            "team" => $apiData->data[0]->team,
            "avatar_url" => $apiData->data[0]->avatar_url
        ];
        $this->assertDatabaseHas('comments', $postData);
        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * Create data
     * 
     * @return void
     */
    public function makeData($totalBook)
    {
        $faker = Faker::create();
        factory(Category::class)->create();
        factory(User::class)->create();
        factory(Donator::class)->create();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, $totalBook)->create([
            'category_id' => 1,
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        $userId = DB::table('users')->pluck('id')->toArray();
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 1; $i++) {
            factory(Post::class, 1)->create([
                'user_id' => $faker->randomElement($userId),
                'book_id' => 1
            ]);
        }
        for ($i = 0; $i <= 3; $i++) {
            factory(Favorite::class, 1)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        // Create parent comment
        factory(Comment::class, 1)->create([
            'user_id' => $faker->randomElement($userId),
            'parent_id' => null,
            'post_id' => 1
        ]);
        // Create child comment
        factory(Comment::class, 1)->create([
            'user_id' => $faker->randomElement($userId),
            'parent_id' => 1,
            'post_id' => 1
        ]);
    }
}
