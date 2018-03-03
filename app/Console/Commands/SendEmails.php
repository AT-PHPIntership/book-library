<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Model\Borrowing;
use App\Jobs\SendMailsJob;
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
        SendMailsJob::dispatch();
        $this->info('Send Mail Success');
    }
}
