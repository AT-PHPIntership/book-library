<?php

namespace App\Model;

use App\Model\Book;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donator extends Model
{
    use SoftDeletes;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'donators';

    /**
     * Default donator
     */
    const DEFAULT_DONATOR = 'AT0001';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_code',
        'email',
        'name',
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

    /**
     * Update donator user, if not exists then create
     *
     * @param String $employeeCode employeeCode
     * @param String $name         name
     *
     * @return int
     */
    public static function updateDonator($employeeCode, $name = null)
    {
        $user = User::where('employee_code', $employeeCode)->first();
        $donatorData = [
            'employee_code' => $employeeCode,
            'name'          => $name,
        ];
        if ($user) {
            $donatorData = [
                'user_id'       => $user->id,
                'employee_code' => $employeeCode,
                'email'         => $user->email,
                'name'          => $user->name,
            ];
        }
        $donator = self::lockForUpdate()->updateOrCreate(['employee_code' => $employeeCode], $donatorData);
        return $donator->id;
    }
}
