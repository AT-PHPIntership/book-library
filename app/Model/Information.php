<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hobby',
        'type',
    ];
    
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
