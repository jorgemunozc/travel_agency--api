<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Travel extends Model
{
    use HasFactory;
    use HasSlug;
    use HasUuids;

    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'name',
        'slug',
        'num_of_days',
        'description',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'num_of_days' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function numOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['num_of_days'] - 1,
        );
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function isPublic(): bool
    {
        return $this->is_public;
    }

    public function isPrivate(): bool
    {
        return ! $this->is_public;
    }
}
