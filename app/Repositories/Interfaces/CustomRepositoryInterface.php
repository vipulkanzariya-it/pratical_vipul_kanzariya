<?php

namespace App\Repositories\Interfaces;

interface CustomRepositoryInterface
{
    public function storeCustomData(array $customData): bool;
}
