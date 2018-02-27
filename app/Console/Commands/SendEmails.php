<?php

namespace App\Console\Commands;

use App\Jobs\SendMailsJob;
use App\Model\Borrowing;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'at-library:send-mail-remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Send reminder e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $borrowings = Borrowing::with('books', 'users')->where('to_date', '=', null)->get();
        SendMailsJob::dispatch($borrowings);
        $this->info('Send Mail Success');
    }
}
