<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BorrowedBookMail;
use App\Model\Borrowing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Validator;

class SendMailController extends Controller
{
    /**
     * Send mail to borrower.
     *
     *@param App\Model\Borrowing $borrowing borrowing
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Borrowing $borrowing)
    {
        if (!canSendMail($borrowing->date_send_email)) {
            flash(__('borrow.messages.sent_mail'))->warning();
            return redirect()->back()->withInput();
        }
        $validator = Validator::make(['email' => $borrowing->users->email], [
            'email' => 'email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors(['message' => trans('portal.messages.not_an_email')])
                        ->withInput();
        }
        Mail::to($borrowing->users->email)->send(new BorrowedBookMail($borrowing));
        $borrowing->date_send_email = Carbon::now();
        $result = $borrowing->save();
        if ($result && empty(Mail::failures())) {
            flash(__('borrow.messages.send_mail_success'))->success();
        } else {
            flash(__('borrow.messages.send_mail_failure'))->error();
        }
        return redirect()->back()->withInput();
    }
}
