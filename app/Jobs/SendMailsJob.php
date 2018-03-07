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
        $borrowings = Borrowing::with('books', 'users')->whereNull('to_date')
            ->where(function ($where) {
                $where->whereDate('from_date', '>=', Carbon::now()->subDays(config('define.time_send_mail'))->toDateString())
                    ->orWhere('date_send_email', null);
            })->get();
        
        \Log::info("Schedule sent mail to remined borrowing book");

        foreach ($borrowings as $borrowing) {
            \Log::info("Start send mail to: " . $borrowing->users->email);

            try {
                $validator = Validator::make(['email' => $borrowing->users->email], [
                    'email' => 'email',
                ]);

                if ($validator->fails()) {
                    \Log::error($validator->fails());
                    continue;
                }

                Mail::to($borrowing->users->email)->send(new BorrowedBookMail($borrowing));
                
                $borrowing->date_send_email = Carbon::now();
                $result = $borrowing->save();

                if ($result == false && !empty(Mail::failures())) {
                    \Log::error(Mail::failures());
                    continue;
                }
                \Log::info("Complete Send Mail");
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                continue;
            }
            \Log::info("End schedule sent mail to remined borrowing book");
        }
    }
}
