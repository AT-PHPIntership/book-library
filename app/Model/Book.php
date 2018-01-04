<?php

namespace App\Model;

use App\Model\User;
use App\Model\Borrowing;
use App\Model\Rating;
use App\Model\Donator;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'QRcode',
        'category_id',
        'name',
        'author',
        'year',
        'price',
        'description',
        'donator_id',
        'avg_rating',
        'total_rating',
        'image',
        'status'
    ];

    /**
     * Relationship morphMany with Post
     *
     * @return array
    */
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    /**
     * Relationship belongsToMany with User
     *
     * @return array
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relationship belongsTo with Category
     *
     * @return array
    */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship belongsTo with Donator
     *
     * @return array
    */
    public function donator()
    {
        return $this->belongsTo(Donator::class, 'donator_id');
    }

    /**
     * Relationship hasMany with Rating
     *
     * @return array
    */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relationship hasMany with Rating
     *
     * @return string
    */
    public function generateQRcode()
    {
        $qrCodes = self::select('QRcode')->orderby('QRcode', 'desc')->limit(1)->get();
        $qrIndex = explode('-', $qrCodes);
        $lastNum = filter_var($qrIndex[1], FILTER_SANITIZE_NUMBER_INT) + 1;

        $finalQRcode = 'BAT-';
        for ($i = 0, $length = 6 - strlen($lastNum); $i < $length; $i++) {
            $finalQRcode .= '0';
        }
        return $finalQRcode .= $lastNum;
    }
    /* Relationship hasMany with Borrow
     *
     * @return array
    */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
