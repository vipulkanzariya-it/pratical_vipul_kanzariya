<?php

namespace App\Services;

use App\Enums\WebhookSource;
use App\Repositories\Eloquent\CustomRepository;
use App\Repositories\Eloquent\GitHubRepository;
use App\Repositories\Eloquent\StripeRepository;
use InvalidArgumentException;

class WebhookService
{
    protected $repositories;

    public function __construct(
        GitHubRepository $gitHubRepository,
        StripeRepository $stripeRepository,
        CustomRepository $customRepository
    ) {
        $this->repositories = [
            'github' => $gitHubRepository,
            'stripe' => $stripeRepository,
            'custom' => $customRepository,
        ];
    }

    public function processData(string $source, array $payload)
    {
        $source = strtolower($source);

        switch ($source) {
            case WebhookSource::GitHub->value:
                $this->repositories[$source]->storeGitHubCommit($payload);
                break;

            case WebhookSource::Stripe->value:
                $this->repositories[$source]->storeStripeTransction($payload);
                break;

            case WebhookSource::Custom->value:
                $this->repositories[$source]->storeCustomData($payload);
                break;

            default:
                throw new InvalidArgumentException('Unknown source');
        }
    }
}
