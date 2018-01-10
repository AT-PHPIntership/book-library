<?php

namespace App\Model;

use App\Model\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrCode extends Model
{
    use SoftDeletes;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'qrcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'QRcode',
        'status',
    ];

    /**
     * Relationship hasOne with Book
     *
     * @return array
    */
    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
