<?php

namespace App\Model;

use App\Libraries\Traits\SearchTrait;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Book;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrowing extends Model
{
    use SoftDeletes, Sortable, SearchTrait;
    
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
     * Filter for search trait
     *
     * @var array $searchable table search
     */
    protected $searchable = [
        'input' => [
            ['users.name', 'like'],
            ['books.name', 'like'],
        ]
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

    // Sort function base on user, book name.
    public $sortableAs = ['employee_code', 'user_name', 'email', 'book_name'];

    /**
     * Get Attribute Date send email
     *
     * @return array
    */
    public function getDateSendMailAttribute()
    {
        return $this->date_send_email ? Carbon::parse($this->date_send_email)->addHours(config('define.timezone'))->format(config('define.datetime_format')) : "";
    }
}
