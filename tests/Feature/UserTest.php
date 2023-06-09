<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testAdminCanCreateNewUserInDb()
    {
        $fakeEmail = fake()->unique()->safeEmail();
        $admin = $this->loginAs();
        $response = $this
            ->actingAs($admin)
            ->postJson('/api/users', [
                'email' => $fakeEmail,
                'password' => fake()->password(8),
            ]);

        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $fakeEmail,
        ]);
    }
}
