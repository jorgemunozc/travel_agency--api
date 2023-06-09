<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Testing\Fluent\AssertableJson;
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
        $user = $this->loginAs('normal');
        $travelData = [
            'name' => 'failed test',
            'num_of_days' => 4,
            'description' => 'A wornderful failed test :d',
        ];
        $response = $this
            ->actingAs($user)
            ->postJson('api/travels', $travelData);
        $response->assertForbidden();
    }

    public function testVisitorsCanViewPublicTravels()
    {
        Travel::factory()->count(8)->create(['is_public' => false]);
        $travels = Travel::factory()->count(4)->public()->create();
        $response = $this->getJson('/api/travels');
        $response
            ->assertSuccessful()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->count('data', $travels->count())
                ->etc());
    }
}
