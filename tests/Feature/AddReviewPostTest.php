<?php

namespace Tests\Feature;

use App\Model\User;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use App\Model\Post;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddNewReviewPost extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $bookId;
    private $faker;

    /**
     * Receive status code 200 in add posts page
     *
     * @return void
     */
    public function testStatusCodeWhenInPostPage()
    {
        $this->makeData();
        $response = $this->POST('/api/posts/');
        $response->assertStatus(Response::HTTP_OK);

    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureAddReviewPost(){
        return [
            'meta' => [
                'message',
                'code'
            ],
            'reviewPost' => [
                'content',
                'book_id',
                'type',
                'user_id',
                'updated_at',
                'created_at',
                'id'
            ],
            'ratingPost' =>[
                'book_id',
                'rating',
                'user_id',
                'updated_at',
                'created_at',
                'id'
            ]
        ];
    }

    /**
     * Test if create fail a review fail.
     *
     * @return void
     */
    public function testIfCreateFail(){
        $this->makeData();
        $response = $this->POST('/api/posts',['content' => 'A','book_id' => $this->bookId,'rating' => $this->faker->numberBetween($min = 1, $max = 5), 'type' => POST::REVIEW_TYPE], ['token' => $this->user['access_token']]);
        $response->assertJsonStructure([
                'meta' => [
                    'message',
                    'code'
                ],
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test structure of add review post.
     *
     * @return void
     */
    public function testStructureAddReviewPost(){
        $this->makeData();
        $response = $this->POST('/api/posts',['content' => $this->faker->text,'rating' => $this->faker->numberBetween($min = 1, $max = 5), 'book_id' => $this->bookId, 'type' => POST::REVIEW_TYPE], ['token' => $this->user['access_token']]);
        $response->assertJsonStructure($this->jsonStructureAddReviewPost());
        $response->assertStatus(Response::HTTP_OK);
        $this->checkDataCreated($response);
    }

    /**
     * Check data after creaeted.
     *
     * @return void
     */
    public function checkDataCreated($response)
     {
         $apiData = json_decode($response->getContent());
         $reviewPost = [
             'content' => $apiData->reviewPost->content,
             'book_id' => $apiData->reviewPost->book_id,
             'type' => $apiData->reviewPost->type,
             'user_id' => $apiData->reviewPost->user_id,
             'updated_at' => $apiData->reviewPost->updated_at,
             'created_at' => $apiData->reviewPost->created_at,
             'id' => $apiData->reviewPost->id,
         ];
         $ratingPost = [
             'rating' => $apiData->ratingPost->rating,
             'book_id' => $apiData->ratingPost->book_id,
             'user_id' => $apiData->ratingPost->user_id,
             'updated_at' => $apiData->ratingPost->updated_at,
             'created_at' => $apiData->ratingPost->created_at,
             'id' => $apiData->ratingPost->id,
         ];
         $this->assertDatabaseHas('posts', $reviewPost);
         $this->assertDatabaseHas('ratings', $ratingPost);
     }

    /**
     * Make data to test
     *
     * @return void
     */
    public function makeData()
    {
        $this->faker = Faker::create();

        $category = factory(Category::class)->create();

        $this->user = factory(User::class)->create();

        $donator = factory(Donator::class)->create([
            'user_id' => $this->user->id,
        ]);

        $this->bookId = factory(Book::class)->create([
            'category_id' => $category->id,
            'donator_id' => $donator->id,
        ])['id'];
    }
}
