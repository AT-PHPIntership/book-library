<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'target_id',
        'target_table',
        'parent_id',
        'content',
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
