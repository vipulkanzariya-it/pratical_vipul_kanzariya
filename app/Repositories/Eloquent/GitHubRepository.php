<?php

namespace App\Repositories\Eloquent;

use App\Models\GitHubCommit;
use App\Repositories\Interfaces\GitHubRepositoryInterface;

class GitHubRepository implements GitHubRepositoryInterface
{
    public function storeGitHubCommit(array $payload): bool
    {
        $timestamp = now();

        $preparedGithubData = [
            ...$payload,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $githubCommitWebhook = GithubCommit::create($preparedGithubData);

        return $githubCommitWebhook !== null;
    }
}
