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
        $travelInput = [
            'name' => 'Japon es increible.',
            'num_of_days' => 23,
            'description' => 'travel all around the japanese temples and experience the buddhism.',
        ];
        $response = $this
            ->actingAs($admin)
            ->postJson('/api/travels', $travelInput);

        $response->assertCreated();
        $this->assertDatabaseCount('travels', 1);
    }

    public function testUserThatIsNotAdminCantCreateTravel(): void
    {
        $user = $this->loginAs('editor');
        $travelData = [];
        $response = $this
            ->actingAs($user)
            ->postJson('api/travels', $travelData);
        $response->assertForbidden();
    }
}
