<?php

namespace Tests\Browser\Pages\Backend\Books;

use DB;
use App\Model\Book;
use App\Model\User;
use App\Model\Post;
use App\Model\QrCode;
use App\Model\Rating;
use App\Model\Comment;
use App\Model\Donator;
use Tests\DuskTestCase;
use App\Model\Favorite;
use App\Model\Category;
use App\Model\Borrowing;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
        for ($i = 1; $i <= 10; $i++) {
            factory(Donator::class)->create([
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
        
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        for ($i = 1; $i <= $rows; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds)
            ]);
        }

        for ($i = 1; $i <= $rows; $i++) {
            factory(QrCode::class)->create([
                'book_id' => $i,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }
    }

    /**
     * Make list of book.
     *
     * @param int $rows number book.
     *
     * @return Book.
     */
    public function makeBooksAndItsRelationship()
    {
        //Make 20 category, 20 user, 20 donator.
        $faker = Faker::create();
        factory(Category::class, 20)->create();
        factory(User::class, 20)->create();
        
        $userIds = DB::table('users')->pluck('id')->toArray();
        for ($i = 1; $i <= 20; $i++) {
            factory(Donator::class)->create([
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
        
        //Make 10 book.
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        for ($i = 1; $i <= 10; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'donator_id' => $faker->randomElement($donatorIds)
            ]);
        }
        
        //Make 20 borrowing, 10 qrcode, 20 rating, 20 post.
        $bookIds = DB::table('books')->pluck('id')->toArray();
        for ($i = 1; $i <= 20; $i++) {
            factory(Borrowing::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds)
            ]);
        }
        
        for ($i = 1; $i <= 10; $i++) {
            factory(QrCode::class)->create([
                'book_id' => $i,
                'code_id' => $faker->unique()->randomNumber(4),
                'prefix' => 'BAT-'
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            factory(Rating::class)->create([
                'book_id' => $faker->randomElement($bookIds),
                'user_id' => $faker->randomElement($userIds),
                'rating'  => rand(1,5)
            ]);
        }
        
        for ($i = 1; $i <= 20; $i++) {
            factory(Post::class)->create([
                'book_id' => $faker->randomElement($bookIds),
                'user_id' => $faker->randomElement($userIds)
            ]);
        }

        //Make 20 comment.
        $postIds = DB::table('posts')->pluck('id')->toArray();
        for ($i = 1; $i <= 20; $i++) {
            factory(Comment::class)->create([
                'post_id' => $faker->randomElement($postIds),
                'user_id' => $faker->randomElement($userIds)
            ]);
        }

        //Make favorite for book, post, comment.
        for ($i = 1; $i <= 20; $i++) {
            factory(Favorite::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'favoritable_id' => $faker->randomElement($bookIds),
                'favoritable_type' => Favorite::TYPE_BOOK
            ]);
        }
        
        for ($i = 1; $i <= 20; $i++) {
            factory(Favorite::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'favoritable_id' => $faker->randomElement($postIds),
                'favoritable_type' => Favorite::TYPE_POST
            ]);
        }
        
        $commentIds = DB::table('comments')->pluck('id')->toArray();
        for ($i = 1; $i <= 20; $i++) {
            factory(Favorite::class)->create([
                'user_id' => $faker->randomElement($userIds),
                'favoritable_id' => $faker->randomElement($commentIds),
                'favoritable_type' => Favorite::TYPE_COMMENT
            ]);
        }
    }
}
