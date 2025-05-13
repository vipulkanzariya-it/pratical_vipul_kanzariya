<?php

namespace Tests\Feature;

use App\Enums\WebhookSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Exception;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    protected string $webhookUrl;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->webhookUrl = env('WEBHOOK_URL_TEST', 'webhook');
    }

    /**
     * Test valid GitHub webhook payload handling.
     */
    public function test_github_webhook_handling()
    {
        $githubCommitData = [
            'commit_id' => '12345',
            'message' => 'Initial commit',
            'author' => 'User A',
        ];
        $payload = $this->generatePayload(WebhookSource::GitHub->name, $githubCommitData);

        $this->sendWebhookPayload(
            $payload,
            'github_commits',
            $githubCommitData
        );
    }

    /**
     * Test valid Stripe webhook payload handling.
     */
    public function test_stripe_webhook_handling()
    {
        $stripeTransactionData = [
            'amount' => 1000,
            'currency' => 'USD',
            'status' => 'succeeded',
        ];
        $payload = $this->generatePayload(WebhookSource::Stripe->name, $stripeTransactionData);

        $this->sendWebhookPayload(
            $payload,
            'stripe_transactions',
            $stripeTransactionData
        );
    }

    /**
     * Test custom source webhook payload handling.
     */
    public function test_custom_source_handling()
    {
        $payloadData = [
            'customer' => [
                'name' => 'Vipul Kanzariya',
                'address' => 'Ahmedabad',
            ],
        ];

        $payload = $this->generatePayload(WebhookSource::Custom->name, $payloadData);

        $response = $this->postJson($this->webhookUrl, $payload);
        $response->assertStatus(200);

        $storedPayload = DB::table('custom_webhooks')->value('payload');
        $this->assertEquals(json_decode($storedPayload, true), $payloadData);
    }

    /**
     * Test invalid payload handling.
     */
    public function test_invalid_payload_missing_source()
    {
        $payload = [
            'source' => '',
            'payload' => [
                'commit_id' => '12345',
                'message' => 'Initial commit',
                'author' => 'User A',
            ],
        ];

        $response = $this->postJson($this->webhookUrl, $payload);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'validation_error',
            'errors' => [
                'source' => ['source is required'],
            ],
        ]);
    }

    /**
     * Test error handling when the database is unavailable.
     */
    public function test_database_unavailability_error_handling()
    {
        $payload = $this->generatePayload('github', [
            'commit_id' => '12345',
            'message' => 'Initial commit',
            'author' => 'User A',
        ]);

        DB::shouldReceive('insert')->andThrow(new Exception('Database unavailable'));

        $response = $this->postJson($this->webhookUrl, $payload);
        $response->assertStatus(200);
    }

    /**
     * Helper function to generate webhook payloads.
     */
    private function generatePayload(string $source, array $payloadData): array
    {
        return [
            'source' => $source,
            'payload' => $payloadData,
        ];
    }

    /**
     * Common function to send webhook payloads and assert database insertion.
     */
    private function sendWebhookPayload(array $payload, string $table, array $assertData)
    {
        $response = $this->postJson($this->webhookUrl, $payload);
        $response->assertStatus(200);
        $this->assertDatabaseHas($table, $assertData);
    }
}
