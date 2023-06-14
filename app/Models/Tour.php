<?php

declare(strict_types=1);

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;
    use HasUuids;
    use Filterable;

    protected $fillable = [
        'name',
        'starting_date',
        'ending_date',
        'price',
    ];

    protected $casts = [
        'starting_date' => 'immutable_datetime',
        'ending_date' => 'immutable_datetime',
    ];

    /** @return Attribute<float,int> */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => (int) ($value * 100),
        );
    }

    /** @return BelongsTo<Travel,Tour> */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
