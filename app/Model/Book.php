<?php

namespace App\Model;

use App\Model\User;
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
    protected $table = 'book';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     * Relationship hasMany with Post
     *
     * @return array
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
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

    public function generateQRcode() {
        $QRCodes = self::select('QRcode')->orderby('QRcode', 'desc')->limit(1)->get();
        $qrIndex = explode('-', $QRCodes);
        $lastNum = filter_var($qrIndex[1], FILTER_SANITIZE_NUMBER_INT) + 1;

        $finalQRcode = 'BAT-';
        for($i = 0, $length = 6 - strlen($lastNum); $i < $length; $i++) {
            $finalQRcode .= '0';
        }
        return $finalQRcode .= $lastNum;
    }
}
