<?php

namespace App\Jobs;

use Validator;
use Carbon\Carbon;
use App\Model\Borrowing;
use Illuminate\Bus\Queueable;
use App\Mail\BorrowedBookMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Console\Command;

class SendMailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $borrowings = Borrowing::with('books', 'users')->where('to_date', '=', null)
                                                       ->where(function ($where) {
                                                           $where->whereDate('from_date', '>=', Carbon::now()->subDays(config('define.time_send_mail'))->toDateString())
                                                                 ->orWhere('date_send_email', null);
                                                       })->get();
        foreach ($borrowings as $borrowing) {
            try {
                $validator = Validator::make(['email' => $borrowing->users->email], [
                    'email' => 'email',
                ]);

                if ($validator->fails()) {
                    continue;
                }
                Mail::to($borrowing->users->email)->send(new BorrowedBookMail($borrowing));
                $borrowing->date_send_email = Carbon::now();
                $result = $borrowing->save();
                if ($result == false && !empty(Mail::failures())) {
                    continue;
                }
            } catch (\Exception $e) {
                \Log::info($e->getMessage());
                continue;
            }
        }
    }
}
