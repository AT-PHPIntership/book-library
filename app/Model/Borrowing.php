<?php

namespace App\Model;

use App\Model\User;
use App\Model\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Borrowing extends Model
{
    use SoftDeletes, Sortable;
    
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
        'date_send_email',
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

    /**
     * Relationship morphMany with Favorite
     * Declare table sort
     *
     * @var array $sortable table sort
     */
    public $sortable = ['from_date', 'to_date', 'date_sent_mail'];
    
    public $sortableAs = ['users.employee_code', 'users.name', 'users.email', 'books.name'];
}
