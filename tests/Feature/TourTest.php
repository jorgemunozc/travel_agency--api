<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Tests\TestCase;

class TourTest extends TestCase
{
    public function testVisitorCanSeeToursForSpecifiedTravel()
    {
        $travel = Travel::factory()
            ->public()
            ->has(Tour::factory()->count(3))
            ->create();
        $response = $this->getJson("/api/travels/{$travel->slug}/tours");
        $response->assertAccepted()
            ->assertJsonCount($travel->loadCount('tours')->tours_count, 'data');
    }

    public function testVisitorCanOnlySeeToursForPublicTravel()
    {
        $travel = Travel::factory()
            ->private()
            ->has(Tour::factory()->count(fake()->randomDigit()))
            ->create();
        $response = $this->getJson("api/travels/{$travel->slug}/tours");
        $response->assertForbidden();
    }

    public function testAdminCanSeeToursForAnyTravel()
    {
        $travels = Travel::factory()
            ->has(Tour::factory()->count(fake()->randomDigit()))
            ->count(fake()->randomDigit())
            ->create();
        $travel = $travels->random();
        $response = $this
            ->actingAs($this->loginAs())
            ->getJson("/api/travels/{$travel->slug}/tours");
        $response->assertAccepted();
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
        $response = $this->getJson("/api/travels/{$travel->slug}/tours?{$query}");
        $response->assertForbidden();
    }
}
