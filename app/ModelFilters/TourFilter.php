<?php

declare(strict_types=1);

namespace App\ModelFilters;

use Carbon\CarbonImmutable;
use EloquentFilter\ModelFilter;

class TourFilter extends ModelFilter
{
    public function priceFrom(int $price): self
    {

        return $this->where('price', '>=', ($price * 100));
    }

    public function priceTo(int $price): self
    {
        return $this->where('price', '<=', ($price * 100));
    }

    public function dateFrom(int $unixTimestamp): self
    {
        $date = CarbonImmutable::createFromTimestampUTC($unixTimestamp);

        return $this->where('starting_date', '>=', $date);
    }

    public function dateTo(int $unixTimestamp): self
    {
        $date = CarbonImmutable::createFromTimestampUTC($unixTimestamp);

        return $this->where('starting_date', '<=', $date);
    }
}
