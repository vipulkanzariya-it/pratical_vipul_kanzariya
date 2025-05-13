<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeTransaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stripe_transactions';

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'amount',
        'currency',
        'status',
    ];
}
