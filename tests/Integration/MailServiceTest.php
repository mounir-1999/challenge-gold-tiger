<?php

namespace Tests\Integration;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Mail\WelcomeMail;
use App\Models\EmailLog;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailServiceTest extends TestCase
{
    public function test_mail_service_adds_to_queue_welcome_mail(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $service = new MailService();
        $service->sendWelcomeMail($user->id);
        // Assert email of type "welcome" is queued
        Mail::assertQueued(WelcomeMail::class);
    }

    public function test_mail_service_adds_to_queue_welcome_mail_with_correct_user(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $service = new MailService();
        $service->sendWelcomeMail($user->id);
        // Assert queued mail is for the correct user
        Mail::assertQueued(function (WelcomeMail $mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }

    public function test_mail_service_checks_for_user_before_queueing_it(): void
    {
        $service = new MailService();
        // expect modelNotFound error
        $this->expectException(ModelNotFoundException::class);
        // set fake value for user id
        $service->sendWelcomeMail("dd");
    }

    public function test_mail_service_dont_queue_if_user_not_exist(): void
    {
        $service = new MailService();
        // expect modelNotFound error
        $this->expectException(ModelNotFoundException::class);
        // set fake value for user id
        $service->sendWelcomeMail("dd");
        // Assert not email is queued
        Mail::assertNotQueued(WelcomeMail::class);
    }

    public function test_mail_service_logs_email_rquests(): void
    {
        $countBefore = EmailLog::count();
        $user = User::factory()->create();
        $service = new MailService();
        $service->sendWelcomeMail($user->id);
        $countAfter = EmailLog::count();
        $this->assertTrue($countAfter == $countBefore + 1);
    }

    public function test_mail_service_dont_log_email_rquests_if_user_not_found(): void
    {
        $countBefore = EmailLog::count();
        $service = new MailService();
        // expect modelNotFound error
        $this->expectException(ModelNotFoundException::class);
        // set fake value for user id
        $service->sendWelcomeMail("dd");
        $countAfter = EmailLog::count();
        $this->assertTrue($countAfter == $countBefore );
    }
}
