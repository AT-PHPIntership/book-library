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
      $count = [
          'users' => User::count(),
          'books' => Book::count(),
          'categories' => Category::count()
        ];
      return $count[$name];
  }
}