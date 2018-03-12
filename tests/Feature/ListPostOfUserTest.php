<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Donator;
use App\Model\Post;
use App\Model\Category;
use Faker\Factory as Faker;

class ListPostOfUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCodeListPosts()
    {
        $this->makeDataListPosts(1);
        $id = User::first()->id;        
        $response = $this->get('/api/users/' . $id . '/posts');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return json structure of list posts of user
     *
     * @return array
     */
    public function jsonStructureListPosts()
    {
        return [
            'data' => [
                [
                    'id',
                    'content',
                    'type',
                    'user_name',
                    'team',
                    'avatar_url',
                    'created_at',
                    'book_name',
                    'image',
                    'updated_at',
                    'avg_rating',
                    'favorites_count',
                    'comments_count',
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
    public function testJsonStructureListPosts()
    {
        $this->makeDataListPosts(1);
        $id = User::first()->id;        
        $response = $this->get('/api/users/' . $id . '/posts');
        $response->assertJsonStructure($this->jsonStructureListPosts());
    }         
    
    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testWithPaginationListPosts()
    {
        $this->makeDataListPosts(21);
        $id = User::first()->id;        
        $response = $this->get('/api/users/' . $id . '/posts' . '?page=2');
        $response->assertJson([
            'current_page' => 2,
            'per_page' => 20,
            'from' => 21,
            'to' => 21,
            'last_page' => 2,
            'next_page_url' => null
        ]);
    }

    /**
     * Test structure of json when empty posts.
     *
     * @return void
     */
    public function testEmptyPosts()
    {   
        $this->makeDataListPosts(0);
        $id = User::first()->id; 
        $response = $this->get('/api/users/' . $id . '/posts');
        $response->assertJson([
            'data' => []
        ]);
    }


    /**
     * Test compare database
     *
     * @return void
     */
    public function testCompareDatabaseListPosts()
    {   
        $this->makeDataListPosts(1);
        $id = User::first()->id; 
        $response = $this->get('/api/users/' . $id . '/posts');
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('posts', [
            'id' => $data->data[0]->id,
            'content' => $data->data[0]->content,
            'type' => $data->data[0]->type,
            'created_at' => $data->data[0]->created_at,
            'updated_at' => $data->data[0]->updated_at,
            'book_name' => $data->data[0]->name
        ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testListPostsCorrectTypePost()
    {
        $this->makeDataListPosts(1);
        $id = User::first()->id;         
        Post::where('id', 1)->update(['type' => '1']);
        $response = $this->get('/api/users/' . $id . '/posts' . '?type=1');
        $response->assertJson([
            'data' => [
                [
                    'type' => '1'
                ],
            ]
        ]);
    }

    /**
     * Make list of book.
     */
    public function makeDataListPosts($rows)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
        $faker = Faker::create();

        factory(Category::class)->create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        factory(User::class)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        
        factory(Donator::class)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $donatorIds = DB::table('donators')->pluck('id')->toArray();

        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
        $bookIds = DB::table('books')->pluck('id')->toArray();

        factory(Post::class, $rows)->create([
            'user_id' => $faker->randomElement($userIds),
            'book_id' => $faker->randomElement($bookIds),
        ]);
    }
}
