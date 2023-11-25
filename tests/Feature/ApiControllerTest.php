<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Mail\WelcomeMail;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_send_welcome_email_route_exists(): void
    {
        $response = $this->post('api/users/1/welcome');
        $this->assertTrue($response->status() != 404);
    }

    /**
     * A basic test example.
     */
    public function test_send_welcome_email_route_sends_email_to_queue(): void
    {
        Mail::fake();
        $this->post('api/users/1/welcome');
        Mail::assertQueued(WelcomeMail::class);
    }
}
