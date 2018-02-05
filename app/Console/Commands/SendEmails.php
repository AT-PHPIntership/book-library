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
    protected $description = 'Send drip e-mails to a user';

    protected $borrowing;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Borrowing $borrowing)
    {
        parent::__construct();
        $this->borrowing = $borrowing;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd($this->borrowing);
        SendMailsJob::dispath($borrowing);
    }
}
