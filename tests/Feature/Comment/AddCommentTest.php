<?php

namespace Tests\Feature\Comment;

use Tests\TestCase;
use App\Model\Comment;
use App\Model\User;
use Faker\Factory as Faker;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddCommentTest extends BaseCommentTest
{
    use DatabaseMigrations;

    /**
     * Request
     *
     * @var array
     */
    private $request;

    /**
     * Access token
     *
     * @var array
     */
    private $token;

    /**
     * Make 20 categorie, 20 user, 20 donator, 10 book, 20 borrowing, 10 qrcode, 20 rating, 20 post, 20 comment, make 20 favorite for book, post, comment. Make default request, default access token and update access toke of first user to default access token
     *
     * @return void
     */
     public function setUp()
    {
        parent::setUp();
        $this->makeData(5);
        User::first()->update(['access_token' => '1']);
        $this->request = [
            'content' => 'content',
            'parent_id' => 1
        ];
        $this->token = ['token' => '1'];
    }

    /**
     * Return structure of json add comment success.
     *
     * @return array
     */
    public function jsonStructureOfAddCommentSuccess(){
        return [
            'data' => [
                'id',
                'post_id',
                'user_id',
                'content',
                'parent_id',
                'created_at',
                'updated_at',
            ],
            'meta' => [
                'message',
                'code'
            ]
        ];
    }

    /**
     * Test add comment success.
     *
     * @return void
     */ 
    public function testAddCommentSuccess()
    {
        //Test json response
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertJsonStructure($this->jsonStructureOfAddCommentSuccess());

        //Compare database
        $dataResponse = json_decode($response->getContent());
        $this->assertDatabaseHas('comments', [
            'id' => $dataResponse->data->id,
            'post_id' => $dataResponse->data->post_id,
            'user_id' => $dataResponse->data->user_id,
            'content' => $dataResponse->data->content,
            'parent_id' => $dataResponse->data->parent_id,
            'created_at' => $dataResponse->data->created_at,
            'updated_at' => $dataResponse->data->updated_at
        ]);
    }

    /**
     * Test add comment when not found post_id.
     *
     * @return void
     */ 
    public function testAddCommentNotFoundPostId()
    {
        $response = $this->POST('api/posts/100/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'message' => 'Page Not Found',
                    'code' => Response::HTTP_NOT_FOUND
                ]
            ]);
    }

    /**
     * Test json response when not found parent_id.
     *
     * @return void
     */ 
    public function testAddCommentNotFoundParentId()
    {
        $this->request['parent_id'] = 100;
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => [
                        'parent_id' => [
                            0 => "The selected parent id is invalid."
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test json response when null parent_id.
     *
     * @return void
     */ 
    public function testAddCommentNullParentId()
    {
        $this->request['parent_id'] = null;
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => [
                        'parent_id' => [
                            0 => "The parent id must be a number."
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test json response when without parent_id.
     *
     * @return void
     */ 
    public function testAddCommentWithoutParentId()
    {
        $this->request = ['content' => 'content'];

        //Created success
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertJson([
                'meta' => [
                    'code' => Response::HTTP_CREATED
                ]
            ]);

        //Parent of its comment is null
        $dataResponse = json_decode($response->getContent());
        $this->assertDatabaseHas('comments', [
            'id' => $dataResponse->data->id,
            'post_id' => $dataResponse->data->post_id,
            'user_id' => $dataResponse->data->user_id,
            'content' => $dataResponse->data->content,
            'parent_id' => null,
            'created_at' => $dataResponse->data->created_at,
            'updated_at' => $dataResponse->data->updated_at
        ]);
    }

    /**
     * Test json response when parent_id not a number.
     *
     * @return void
     */ 
    public function testAddCommentWhenParentIdNotANumber()
    {
        $this->request['parent_id'] = 'a';
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => [
                        'parent_id' => [
                            0 => "The parent id must be a number."
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test json response when content is null.
     *
     * @return void
     */ 
    public function testAddCommentWhenContentIsNull()
    {
        $this->request['content'] = null;
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => [
                        'content' => [
                            0 => "The content field is required."
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test json response when without content.
     *
     * @return void
     */ 
    public function testAddCommentWhenWithoutContent()
    {
        $this->request = ['parent_id' => 1];
        $response = $this->POST('api/posts/1/comment', $this->request, $this->token)
            ->assertExactJson([
                'meta' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => [
                        'content' => [
                            0 => "The content field is required."
                        ]
                    ]
                ]
            ]);
    }
}
