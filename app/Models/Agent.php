<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $agency_name
 * @property string|null $license_number
 * @property numeric $commission_rate Percentage e.g. 5.00 = 5%
 * @property int $is_active
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Property> $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent whereUserId($value)
 * @mixin \Eloquent
 */
class Agent extends Model
{
    protected $table = 'agents';
    protected $fillable = [
        'user_id',
        'agency_name',
        'license_number',
        'commission_rate',
        'is_active',
        'bio',
    ];
    public function properties() : HasMany {
        return $this->hasMany(Property::class);
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function transactions() : HasMany{
        return $this->hasMany(Transaction::class);
    }
}