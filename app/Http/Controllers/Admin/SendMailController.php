<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Http\Controllers\Controller;

class SendMailController extends Controller
{
    /**
     * Send mail to borrower.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail()
    {
        return view('backend.email.index');
    }
}
