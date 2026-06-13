<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $reference Public-facing transaction ID e.g. TXN-2025-00042
 * @property int $property_id
 * @property int $buyer_id
 * @property int $agent_id
 * @property int|null $rent_id
 * @property string $transaction_type
 * @property string $status
 * @property int $amount_cents Amount in cents
 * @property string $currency
 * @property int|null $commission_cents Agent commission in cents
 * @property string|null $payment_method e.g. bank_transfer, stripe, paypal
 * @property string|null $payment_reference
 * @property string|null $notes
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAmountCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCommissionCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereRentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'reference',
        'property_id',
        'buyer_id',
        'agent_id',
        'rent_id',
        'transaction_type',
        'status',
        'amount_cents',
        'currency',
        'commission_cents',
        'payment_method',
        'payment_refence',
        'notes',
        'paid_at'
    ];

    public function property() : BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}