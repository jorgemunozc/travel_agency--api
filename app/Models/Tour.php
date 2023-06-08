<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'starting_date',
        'ending_date',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
        'starting_date' => 'immutable_datetime',
        'ending_date' => 'immutable_datetime',
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (int $value) => $value * 100,
        );
    }

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
