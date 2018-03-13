<?php

namespace Tests\Feature\Comment;

use Tests\TestCase;
use App\Model\Category;
use App\Model\User;
use App\Model\Donator;
use App\Model\Book;
use App\Model\QrCode;
use App\Model\Post;
use App\Model\Comment;
use DB;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BaseCommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Make 5 categories, 5 users, 5 donators, 5 books, 5 qrcodes, 5 posts, $rows comments.
     *
     * @param Int $rows number comments.
     *
     * @return void
     */
    public function makeData($rows)
    {
        //Make 5 categories & 5 users
        $faker = Faker::create();
        factory(Category::class, 5)->create();
        factory(User::class, 5)->create();

        //Make 5 donators
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            factory(Donator::class)->create([
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
        
        //Make 5 books
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds)
            ]);
        }

        //Make 5 qrcodes
        for ($i = 1; $i <= 5; $i++) {
            factory(QrCode::class)->create([
                'book_id' => $i,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }

        //Make 5 posts
        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            factory(Post::class)->create([
                'book_id' => $faker->randomElement($bookIds),
                'user_id' => $faker->randomElement($userIds)
            ]);
        }

        //Make $rows comment.
        $postIds = DB::table('posts')->pluck('id')->toArray();
        for ($i = 1; $i <= $rows; $i++) {
            factory(Comment::class)->create([
                'post_id' => $faker->randomElement($postIds),
                'user_id' => $faker->randomElement($userIds)
            ]);
        }
    }
}
