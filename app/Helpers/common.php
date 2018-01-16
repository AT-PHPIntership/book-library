<?php

use App\Model\User;
use App\Model\Book;
use App\Model\Post;
use App\Model\Category;

if (!function_exists('getCount')) {
  
  /**
   * Get percent progress name of database
   *
   * @param string $name name of database
   *
   * @return float
   */
    function getCount($name)
    {
        /**
         * Response count
         *
         * @param int $count count table
         */
        $count = 0;
        switch ($name) {
            case User::class:
                $count = User::count();
                break;
            case Book::class:
                $count = Book::count();
                break;
            case Post::class:
                $count = Post::count();
                break;
            default:
                $count = Category::count();
        }
        return $count;
    }
}
