<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendWelcomeEmailCommandTest extends TestCase
{
    public function test_send_welcome_email_command_works_without_issues(): void
    {
        $user = User::factory()->create();
        $this->artisan('mails:welcome ' . $user->id)->assertExitCode(0);
    }

    public function test_send_welcome_email_command_sends_email_to_queue(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->artisan('mails:welcome ' . $user->id)->assertExitCode(0);

        Mail::assertQueued(WelcomeMail::class);
    }
}
