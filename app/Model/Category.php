<?php

namespace App\Model;

use DB;
use App\Model\Book;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    const DEFAULT_CATEGORY = 1;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relationship hasMany with Book
     *
     * @return array
    */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Delete category and set book's category_id to default
     *
     * @param App\Model\Category $category instance of Category model
     *
     * @return void
     */
    public function deleteAndSetDefault(Category $category)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Book::where('category_id', $category->id)->update(['category_id' => Category::DEFAULT_CATEGORY]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $category->delete();
    }
}
