<?php

namespace Tests\Feature;

use App\Model\User;
use Tests\TestCase;
use Faker\Factory as Faker;
use DB;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use App\Model\Post;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddNewReviewPost extends TestCase
{
    use DatabaseMigrations;

    /**
     * Receive status code 200 in add posts page
     *
     * @return void
     */
    public function testStatusCodeWhenInPostPage()
    {
        $this->makeUser();
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
                'user_id',
                'content',
                'type',
                'updated_at',
                'created_at',
                'id',
            ],
            'ratingPost' =>[
                'user_id',
                'book_id',
                'rating',
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
        $this->makeUser();
        $user = User::find(1);
        $this->makeData(1);
        $response = $this->POST('/api/posts',['content' => 'abc','rating' => '1', 'book_id' => '2'], ['token' => $user->access_token]);
        $response->assertJsonStructure([
                'meta' => [
                    'message',
                    'code'
                ],
        ])->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Test structure of json.
     *
     * @return void
     */
    public function testStructureAddReviewPost(){
        $this->makeUser();
        $user = User::find(1);
        $this->makeData(1);
        $response = $this->POST('/api/posts',['content' => 'abc','rating' => '1', 'book_id' => '1'], ['token' => $user->access_token]);
        $response->assertJsonStructure($this->jsonStructureAddReviewPost());
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Make data to test
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();

        factory(Category::class)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $userIds = DB::table('users')->pluck('id')->toArray();

        $donator = factory(Donator::class)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i = 0; $i < $row; $i++) {
            factory(Post::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
            ]);
        }
    }

    /**
     * Make user to login
     *
     * @return void
     */
    public function makeUser(){
         \DB::table('users')->insert([
            'id' => '1',
            'employee_code' => 'AT0123',
            'name' => 'SA Nguyen',
            'email' => 'sa.nguyen@gmail.com',
            'team' => 'SA',
            'role' => '1',
            'access_token' => '123'
        ]);

    }
}
