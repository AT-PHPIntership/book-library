<?php

namespace App\Model;

use App\Model\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrCode extends Model
{
    use SoftDeletes;

        
    /**
     * Default code_id of qrcode
     */
    const DEFAULT_CODE_ID = 1;
    /**
     * QrCode prefix
     */
    const QRCODE_PREFIX = 'ABT';
    
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
        'book_id',
        'prefix',
        'code_id',
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
