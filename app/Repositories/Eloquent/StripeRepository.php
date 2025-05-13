<?php

namespace App\Repositories\Eloquent;

use App\Models\StripeTransaction;
use App\Repositories\Interfaces\StripeRepositoryInterface;

class StripeRepository implements StripeRepositoryInterface
{
    public function storeStripeTransction(array $transactionData): bool
    {
        $timestamp = now();
        $preparedGithubData = [
            ...$transactionData,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        $stripeTransactionWebhook = StripeTransaction::create($preparedGithubData);

        return $stripeTransactionWebhook !== null;
    }
}
