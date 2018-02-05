<?php

namespace App\Jobs;

use App\Mail\BorrowedBookMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($borrowing)
    {
        $this->borrowing = $borrowing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $borrowings = Borrowing::leftjoin('users', 'user_id', 'users.id');
        dd($borrowings);
        Mail::to($borrowing->users->email)->send(new BorrowedBookMail($borrowing));
        $borrowing->date_send_email = Carbon::now();
        $result = $borrowing->save();
    }
}
