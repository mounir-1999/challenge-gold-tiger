<?php

namespace App\Console\Commands;

use App\Services\MailService;
use Illuminate\Console\Command;

class SendWelcomeEmails extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mails:welcome {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a welcome mail to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mail = new MailService();
        $mail->sendWelcomeMail($this->argument('user_id'));
    }
}
