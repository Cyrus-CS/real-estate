<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $property_id
 * @property int $applicant_id
 * @property string $status
 * @property string|null $message Applicant cover message
 * @property string|null $rejection_reason
 * @property \Illuminate\Support\Carbon|null $desired_move_in
 * @property int|null $lease_duration_months
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $applicant
 * @property-read \App\Models\Property|null $property
 * @property-read \App\Models\User|null $reviewer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereDesiredMoveIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereLeaseDurationMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent withoutTrashed()
 * @mixin \Eloquent
 */
class Rent extends Model
{
    use SoftDeletes;
    protected $table = 'rents';

    protected $fillable = [
        'property_id',
        'applicant_id',
        'status',
        'message',
        'rejection_reason',
        'desired_move_in',
        'lease_duration_months',
        'reviewed_at',
        'reviewed_by'
    ];

    protected $casts = [
        'desired_move_in' => 'date',
        'reviewed_at'     => 'datetime',
    ];

    public function property() : BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

}