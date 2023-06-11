<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Roles;
use App\Models\Travel;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TravelTest extends TestCase
{
    private string $TRAVEL_API_ENDPOINT = '/api/v1/travels';

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
            ->postJson($this->TRAVEL_API_ENDPOINT, $travelInput);

        $response->assertCreated();
        $this->assertDatabaseCount('travels', 1);
    }

    public function testUserThatIsNotAdminCantCreateTravel(): void
    {
        $user = $this->loginAs(Roles::Normal);
        $travelData = [
            'name' => 'failed test',
            'num_of_days' => 4,
            'description' => 'A wornderful failed test :d',
        ];
        $response = $this
            ->actingAs($user)
            ->postJson($this->TRAVEL_API_ENDPOINT, $travelData);
        $response->assertForbidden();
    }

    public function testVisitorsCanViewPublicTravels()
    {
        Travel::factory()->count(8)->create(['is_public' => false]);
        $travels = Travel::factory()->count(4)->public()->create();
        $response = $this->getJson($this->TRAVEL_API_ENDPOINT);
        $response
            ->assertSuccessful()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data')
                ->has('meta')
                ->count('data', $travels->count())
                ->etc());
    }

    public function testEditorCanUpdateTravel()
    {
        $user = $this->loginAs(Roles::Editor);
        $travel = Travel::factory()->private()->create();
        $response = $this->actingAs($user)
            ->putJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->id}", [
                'name' => 'Juan Carlos En Vivo',
                'is_public' => true,
            ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas($travel->getTable(), [
            'id' => $travel->id,
            'name' => 'Juan Carlos En Vivo',
            'is_public' => true,
        ]);
    }

    public function testOnlyEditorsAndAdminCanUpdateTravels()
    {
        $user = $this->loginAs(Roles::Normal);
        $travel = Travel::factory()->create();
        $newDescription = 'I cant update this travel because I have no power :(';
        $response = $this->actingAs($user)
            ->putJson("{$this->TRAVEL_API_ENDPOINT}/{$travel->id}", [
                'description' => $newDescription,
            ]);
        $response->assertForbidden();
        $this->assertDatabaseMissing($travel->getTable(), [
            'id' => $travel->id,
            'description' => $newDescription,
        ]);
    }
}
