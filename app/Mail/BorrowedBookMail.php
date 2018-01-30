<?php

namespace App\Mail;

use App\Model\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BorrowedBookMail extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * Object of Borrowing
     */
    public $borrowing;

    /**
     * Create a new message instance.
     *
     * @param App\Model\Borrowing $borrowing information borrowing
     *
     * @return void
     */
    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Reminder Borrowed Book Email';
        return $this->view('backend.email.index')
                    ->with(['borrowing' => $this->borrowing])
                    ->from(Auth::user()->email, Auth::user()->name)
                    ->subject($subject);
    }
}
