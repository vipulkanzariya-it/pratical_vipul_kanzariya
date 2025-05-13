<?php

namespace App\Repositories\Interfaces;

interface StripeRepositoryInterface
{
    public function storeStripeTransction(array $transactionData): bool;
}
