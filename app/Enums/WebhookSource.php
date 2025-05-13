<?php

namespace App\Enums;

enum WebhookSource: string
{
    case GitHub = 'github';
    case Stripe = 'stripe';
    case Custom = 'custom';

    /**
     * Get the human-readable name of the source.
     */
    public function label(): string
    {
        return match ($this) {
            self::GitHub => 'GitHub Webhook',
            self::Stripe => 'Stripe Webhook',
            self::Custom => 'Custom Webhook',
        };
    }
}
