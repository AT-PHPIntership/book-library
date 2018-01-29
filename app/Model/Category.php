<?php

namespace App\Model;

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
}
