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
        $count = '';
        switch ($name) {
            case 'users':
                $count = User::count();
                break;
            case 'books':
                $count = Book::count();
                break;
            default:
                $count = Category::count();
                break;
        }
        return $count;
    }
}
