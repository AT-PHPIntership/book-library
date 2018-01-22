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
    public function updateRole($id)
    {
        $user = User::findOrFail($id);
        if ($user->team !== User::SA) {
            $newRole = 1 - $user->role;
            $user->update(['role' => $newRole]);
            $data = $newRole;
        } else {
            $data = -1;
        }
        return response()->json($data);
    }
}
