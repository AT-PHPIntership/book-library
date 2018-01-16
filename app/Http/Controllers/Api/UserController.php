<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\User;

class UserController extends Controller
{
    /**
     * Change role of user.
     *
     * @param int $id id of user
     *
     * @return \Illuminate\Http\Response
     */
    public function roles($id)
    {
        $getUser = User::findOrFail($id);
        $newRole = 1 - $getUser->role;
        $getUser->update(['role' => $newRole]);
        $data = [
            'user' => $getUser,
        ];
        return response()->json($data);
    }
}
