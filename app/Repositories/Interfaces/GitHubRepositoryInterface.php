<?php

namespace App\Repositories\Interfaces;

interface GitHubRepositoryInterface
{
    public function storeGitHubCommit(array $commitData): bool;
}
