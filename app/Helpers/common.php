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

if (!function_exists('isActiveRoute')) {
    
    /**
     * Active menu side bar when route menu is current route
     *
     * @param string $route  route of page
     * @param string $output active or ''
     *
     * @return string
     */
    function isActiveRoute($route, $output = "active")
    {
        if (Route::currentRouteName() == $route) {
            return $output;
        }
    }
}

if (!function_exists('areActiveRoute')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param Array  $routes routes action
     * @param string $output active or ''
     *
     * @return string
     */
    function areActiveRoute(array $routes, $output = "active")
    {
        if (in_array(Route::currentRouteName(), $routes, true)) {
            return $output;
        }
    }
}
