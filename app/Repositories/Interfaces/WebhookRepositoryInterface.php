<?php

namespace App\Repositories\Interfaces;

interface WebhookRepositoryInterface
{
    //public function logWebhook(string $source, array $payload): bool;
    public function storeGitHubCommit(array $commitData): bool;
    //public function storeStripeTransaction(array $transactionData): bool;
}
