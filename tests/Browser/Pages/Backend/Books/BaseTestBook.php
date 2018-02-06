<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Donator;
use App\Model\Borrowing;
use App\Model\QrCode;
use App\Model\Rating;
use App\Model\Post;
use App\Model\Comment;
use App\Model\Favorite;
use Faker\Factory as Faker;

class BaseTestBook extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make list of book.
     *
     * @param int $rows number book.
     *
     * @return Book.
     */
    public function makeListOfBook($rows)
    {
        $faker = Faker::create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        factory(Book::class, $rows)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
        ]);
    }

    /**
     * Make list of book.
     *
     * @param int $rows number book.
     *
     * @return Book.
     */
    public function makeABookAndItsRelationship()
    {
        //Make category, user, donator.
        $faker = Faker::create();
        factory(Category::class)->create();
        factory(User::class)->create();
        $userID = DB::table('users')->pluck('id')->first();
        factory(Donator::class)->create([
            'user_id' => $userID,
        ]);

        //Make book.
        $categoryID = DB::table('categories')->pluck('id')->first();
        $donatorID = DB::table('donators')->pluck('id')->first();
        factory(Book::class)->create([
            'category_id' => $categoryID,
            'donator_id' => $donatorID,
        ]);

        //Make borrowing, qrcode, rating, post.
        $bookID = DB::table('books')->pluck('id')->first();
        factory(Borrowing::class)->create([
            'user_id' => $userID,
            'book_id' => $bookID,
        ]);
        factory(QrCode::class)->create([
            'book_id' => $bookID,
            'prefix' => 'BAT-',
            'code_id' => $faker->unique()->randomNumber(4),
        ]);
        factory(Rating::class)->create([
            'book_id' => $bookID,
            'user_id' => $userID,
            'rating'  => rand(1,5),
        ]);
        factory(Post::class)->create([
            'book_id' => $bookID,
            'user_id' => $userID,
        ]);

        //Make comment.
        $postID = DB::table('posts')->pluck('id')->first();
        factory(Comment::class)->create([
            'post_id' => $postID,
            'user_id' => $userID,
        ]);

        //Make favorite for book, post, comment.
        factory(Favorite::class)->create([
            'user_id' => $userID,
            'favoritable_id' => $bookID,
            'favoritable_type' => Favorite::TYPE_BOOK,
        ]);
        factory(Favorite::class)->create([
            'user_id' => $userID,
            'favoritable_id' => $postID,
            'favoritable_type' => Favorite::TYPE_POST,
        ]);
        $commentID = DB::table('comments')->pluck('id')->first();
        factory(Favorite::class)->create([
            'user_id' => $userID,
            'favoritable_id' => $commentID,
            'favoritable_type' => Favorite::TYPE_COMMENT,
        ]);
    }
}
