<?php

namespace App\Repositories\Eloquent;

use App\Models\CustomWebhook;
use App\Repositories\Interfaces\CustomRepositoryInterface;

class CustomRepository implements CustomRepositoryInterface
{
    public function storeCustomData(array $customData): bool
    {
        $timestamp = now();

        $preparedCustomData = [
            'payload' => $customData,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        $customWebhook = CustomWebhook::create($preparedCustomData);

        return $customWebhook !== null;
    }
}
