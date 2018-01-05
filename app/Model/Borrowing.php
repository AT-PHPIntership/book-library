<?php

namespace App\Model;

use App\Model\User;
use App\Model\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrowing extends Model
{
    use SoftDeletes;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'borrowings';

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
    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
