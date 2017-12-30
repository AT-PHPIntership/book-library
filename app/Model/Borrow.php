<?php

namespace App\Model;

use App\Model\User;
use App\Model\Book;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'borrows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'from_date',
        'to_date',
    ];

    /**
     * Relationship belongsTo with Book
     *
     * @return array
    */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
