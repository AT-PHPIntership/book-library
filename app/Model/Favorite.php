<?php

namespace App\Model;

use App\Model\Post;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{

    use SoftDeletes;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];
    
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
     * Get all of the owning favoritable models
     *
     * @return array
    */
    public function favoritable()
    {
        return $this->morphTo();
    }
}
