<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TourTest extends TestCase
{
    private string $TRAVEL_API_ENDPOINT = '/api/v1/travels';

    public function testVisitorCanSeeToursForSpecifiedTravel()
    {
        $travel = Travel::factory()
            ->public()
            ->has(Tour::factory()->count(3))
            ->create();
        $response = $this->getJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->slug}/tours");
        $response->assertSuccessful()
            ->assertJsonCount($travel->loadCount('tours')->tours_count, 'data');
    }

    public function testVisitorCanOnlySeeToursForPublicTravel()
    {
        $travel = Travel::factory()
            ->private()
            ->has(Tour::factory()->count(fake()->numberBetween(1, 5)))
            ->create();
        $response = $this->getJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->slug}/tours");
        $response->assertForbidden();
    }

    public function testAdminCanSeeToursForAnyTravel()
    {
        $travels = Travel::factory()
            ->has(Tour::factory()->count(fake()->numberBetween(1, 9)))
            ->count(3)
            ->create();
        $travel = $travels->random();
        $response = $this
            ->actingAs($this->loginAs())
            ->getJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->slug}/tours");
        $response->assertJsonCount($travel->tours()->count(), 'data');
    }

    /** @group db */
    public function testVisitorCanSeeOnlyToursFilteredBetweenPrices()
    {
        $lowestPriceRange = 990.99;
        $highestPriceRange = 1500.45;
        $travel = Travel::factory()->public()->create();
        $tourWithLowestPriceInRange = Tour::factory()
            ->for($travel)
            ->create([
                'price' => $lowestPriceRange,
            ]);
        $tourWithHighestPriceRange = Tour::factory()
            ->for($travel)
            ->create([
                'price' => $highestPriceRange,
            ]);
        $tourWithPriceOutsideOfRange = Tour::factory()
            ->for($travel)
            ->create([
                'price' => ($highestPriceRange) + 150,
            ]);
        $response = $this->json('GET', "{$this->TRAVEL_API_ENDPOINT}/{$travel->slug}/tours", [
            'priceFrom' => $lowestPriceRange,
            'priceTo' => $highestPriceRange,
        ]);
        $response
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', 2, fn (AssertableJson $item) => $item
                    ->where('id', fn (string $id) => in_array($id, [$tourWithHighestPriceRange->id, $tourWithLowestPriceInRange->id]))
                    ->where('price', function (string $price) use ($lowestPriceRange, $highestPriceRange) {

                        return (float) $price >= $lowestPriceRange && (float) $price <= $highestPriceRange;
                    })
                    ->etc()
                )
                ->etc()
            );
    }

    public function testVisitorCantSeeFilterErrorsInPrivateTravel()
    {
        $travel = Travel::factory()->private()
            ->has(Tour::factory()->count(3))
            ->create();
        $queryParams = [
            'priceFrom' => 3000,
            'priceTo' => 100,

        ];
        $query = http_build_query($queryParams);
        $response = $this->getJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->slug}/tours?{$query}");
        $response->assertForbidden();
    }
}
