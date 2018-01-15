<?php

use App\Model\User;
use App\Model\Book;
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
            case config('define.count_num.users'):
                $count = User::count();
                break;
            case config('define.count_num.books'):
                $count = Book::count();
                break;
            default:
                $count = Category::count();
        }
        return $count;
    }
}
