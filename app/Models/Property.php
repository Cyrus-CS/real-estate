<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Agent;
use App\Models\Amenity;
use App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $agent_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property PropertyType $type
 * @property PropertyStatus $status
 * @property int $price Price in cents for precision
 * @property int|null $surface
 * @property int $bedrooms
 * @property int $bathrooms
 * @property int|null $floors
 * @property int|null $year_built
 * @property string|null $cover_image
 * @property string $address
 * @property string $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string $country
 * @property bool $is_featured
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Agent $agent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Amenity> $amenities
 * @property-read int|null $amenities_count
 * @property-read string $formatted_price
 * @property-read string $status_label
 * @property-read string $type_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PropertyImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereYearBuilt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withoutTrashed()
 * @mixin \Eloquent
 */
class Property extends Model
{
    protected $table = 'properties';
    use SoftDeletes;
    protected $fillable = [
        'agent_id',
        'title', 
        'slug',
        'description',
        'type',
        'status',
        'price',
        'surface',
        'bedrooms',
        'bathrooms',
        'floors',
        'year_built',
        'address',
        'city',
        'state',
        'zip_code',
        'is_featured',
        'country',
        'is_featured',
        'is_published',
        'cover_image',
        'slug'
    ];

    protected $casts = [
        'type' => PropertyType::class,     
        'status' => PropertyStatus::class,  
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'price' => 'integer',
        'surface' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floors' => 'integer',
        'year_built' => 'integer',
    ];

    /**
     * Boot du modèle pour auto-génération du slug
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });

        static::updating(function ($property) {
            if ($property->isDirty('title')) {
                $property->slug = Str::slug($property->title);
            }
        });
    }

    /**
     * Relations
     */
    public function agent() : BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /***
     * La relation entre properties et amenities est Many-to-Many (N:N).

        Une propriété peut avoir plusieurs amenities (pool, gym, parking…)
        Une amenity peut appartenir à plusieurs propriétés (plusieurs propriétés peuvent avoir une piscine, par exemple)
     */

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    public function images() : HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function firstImage()
    {
        $first = $this->images()->first();
        if(!$first){
            return asset('asset/img/default-property.jpg'); // image par défaut
        }
        return asset('storage/' . $first->image_path);
    }

    /**
     * Accesseurs utiles
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price / 100, 2, ',', ' ') . ' €';
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type->label();
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }
    
}