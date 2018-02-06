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

    protected $borrowings;
    /**
     * Create a new job instance.
     *
     * @param Object $borrowings get value borrowing
     *
     * @return void
     */
    public function __construct($borrowings)
    {
        $this->borrowings = $borrowings;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->borrowings as $borrowing) {
            if (canSendMail($borrowing->date_send_email)) {
                if (Carbon::now()->diffInDays(Carbon::parse($borrowing->from_date)) >= 14) {
                    Mail::to($borrowing->users->email)->send(new BorrowedBookMail($borrowing));
                    $borrowing->date_send_email = Carbon::now();
                    $borrowing->save();
                }
            }
        }
    }
}
