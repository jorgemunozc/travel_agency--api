<?php

declare(strict_types=1);

namespace App\ModelFilters;

use Carbon\CarbonImmutable;
use EloquentFilter\ModelFilter;

class TourFilter extends ModelFilter
{
    /** @return \Illuminate\Database\Eloquent\Builder<\App\Models\Tour> */
    public function priceFrom(float $price)
    {

        return $this->where('price', '>=', (int) ($price * 100));
    }

    /** @return \Illuminate\Database\Eloquent\Builder<\App\Models\Tour> */
    public function priceTo(float $price)
    {
        return $this->where('price', '<=', (int) ($price * 100));
    }

    /** @return \Illuminate\Database\Eloquent\Builder<\App\Models\Tour> */
    public function dateFrom(int $unixTimestamp)
    {
        $date = CarbonImmutable::createFromTimestampUTC($unixTimestamp);

        return $this->where('starting_date', '>=', $date);
    }

    /** @return \Illuminate\Database\Eloquent\Builder<\App\Models\Tour> */
    public function dateTo(int $unixTimestamp)
    {
        $date = CarbonImmutable::createFromTimestampUTC($unixTimestamp);

        return $this->where('starting_date', '<=', $date);
    }
}
