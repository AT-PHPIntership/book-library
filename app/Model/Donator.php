<?php

namespace App\Model;

use App\Model\Book;
use Illuminate\Database\Eloquent\Model;

class Donator extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'donator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_code',
        'email',
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
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
