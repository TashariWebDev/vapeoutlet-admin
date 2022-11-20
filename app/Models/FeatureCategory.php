<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * App\Models\FeatureCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feature[] $features
 * @property-read int|null $features_count
 *
 * @method static \Database\Factories\FeatureCategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeatureCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }

    public function features(): hasMany
    {
        return $this->hasMany(Feature::class);
    }
}
