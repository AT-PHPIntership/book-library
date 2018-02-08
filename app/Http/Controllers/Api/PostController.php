<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $post;

    /**
     * UserAPIController constructor.
     *
     * @param User $user Dependence injection
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Add review Post.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(Auth::user());
        $post = $this->post->create($request->all());
        dd($post);
//        $posts = Post::insert()
////            ->withCount('books')
////            ->groupBy('id')
//            ->paginate(config('define.page_length'));
//        return response()->json($posts);
    }
}