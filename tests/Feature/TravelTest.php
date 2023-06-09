<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class TravelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAdminCanCreateNewTravel(): void
    {
        $admin = $this->loginAs();
        $travelInput = [];
        $response = $this
            ->actingAs($admin)
            ->postJson('/api/travels', $travelInput);

        $response->assertCreated();
        $this->assertDatabaseCount('travels', 1);
    }
}
