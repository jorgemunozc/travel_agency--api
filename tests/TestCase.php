<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function loginAs(string $userType = 'admin'): Authenticatable
    {
        return match ($userType) {
            'admin' => User::factory()
                ->has(Role::factory()->admin()->count(1))
                ->create(),
            default => User::factory()->create()
        };
    }
}
