<?php

namespace Tests\Feature;

use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Post;
use Tests\TestCase;
use App\Model\Donator;
use App\Model\Comment;
use App\Model\Category;
use Faker\Factory as Faker;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentUpdateTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->makeData();
    }

    /**
     * test status return when connect api update comment success.
     *
     * @return void
     */
    public function testStatusUpdateCommentReturn()
    { 
        $user1 = User::find(1);
        $response = $this->put('/api/comments/1', ['content' => 'abc'], ['token' => $user1->access_token]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json when update comment success.
     *
     * @return array
     */
    public function testJsonStructureWhenUpdateComment()
    {
        $user1 = User::find(1);
        $response = $this->put('/api/comments/1', ['content' => 'abc'], ['token' => $user1->access_token]);
        $response->assertJsonStructure([                                                                                                                        
            'meta' => [
                'message',
                'code'
            ],                                                                                                                                                                                                                                                                                                                                                                                                                      
            'data' => [
                'id',
                'post_id',
                'user_id',
                'content',
                'parent_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }        

    /**
     * test when update comment with content is empty.
     *
     * @return void
     */
    public function testUpdateCommentWhenContentEmpty()
    { 
        $user1 = User::find(1);
        $response = $this->put('/api/comments/1', ['content' => ''], ['token' => $user1->access_token]);
        $response->assertJson([
            'meta' => [
                'code' => 400,
                'message' => [
                    'content' => [
                        0 => 'The content field is required.'
                    ]
                ]
            ]
        ]);
        $response->assertJsonMissing([
            'data' => [
                'id',
                'post_id',
                'user_id',
                'content',
                'parent_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    /**
     * Test content of comment after update comment success.
     *
     * @return void
     */
    public function testContentAfterUpdateComment()
    {
        $user1 = User::find(1);
        $response = $this->put('/api/comments/1', ['content' => 'new comment'], ['token' => $user1->access_token]);
        $datas = json_decode($response->getContent());
        $arrayComment = [
            'content' => 'new comment',  
        ];
        $this->assertDatabaseHas('comments', $arrayComment);
    }

    /**
     * Test edit comment which is not belong to self.
     *
     * @return void
     */
    public function testUpdateCommentNotBelongTo(){
        $user2 = User::find(2);
        $response = $this->put('/api/comments/1', ['content' => 'abcd'], ['token' => $user2->access_token]);
        $response->assertJson([
            'meta' => [
                'message' => 'You dont have permission to edit',
                'code' => 403
            ] 
        ]);
        $response->assertJsonMissing([
            'data' => [
                'id',
                'post_id',
                'user_id',
                'content',
                'parent_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    /**
     * Test edit comment which is not exit.
     *
     * @return void
     */
    public function testUpdateCommentNotExit(){
        $user1 = User::find(1);
        $response = $this->put('/api/comments/2', ['content' => 'abc'], ['token' => $user1->access_token]);
        $response->assertJson([
            'error' => [
                'message' => 'Comment not found'
            ]        
        ]);
        $response->assertJsonMissing([
            'data' => [
                'id',
                'post_id',
                'user_id',
                'content',
                'parent_id',
                'created_at',
                'updated_at',
                'deleted_at'
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
        $user1 = factory(User::class)->create([
            'access_token' => $faker->name
        ]); 
        $user2 = factory(User::class)->create([
            'access_token' => $faker->name
        ]);
        factory(Category::class)->create();
        factory(Donator::class)->create([
            'user_id' => 1,
        ]);
        factory(Book::class)->create([
            'category_id' => 1,
            'donator_id' => 1,
        ]);
        factory(Post::class)->create([
            'book_id' => 1,
            'user_id' => 1,
        ]);
        factory(Comment::class)->create([
            'post_id' => 1,
            'user_id' => 1,
            'content' => $faker->name,
        ]);
    }
}
