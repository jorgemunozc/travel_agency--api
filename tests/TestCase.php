<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function loginAs(Roles $userType = Roles::Admin): Authenticatable
    {
        return match ($userType) {
            Roles::Admin => User::factory()
                ->has(Role::factory()->admin())
                ->create(),
            Roles::Editor => User::factory()
                ->has(Role::factory()->editor())
                ->create(),
            default => User::factory()
                ->has(Role::factory()->normal())
                ->create()
        };
    }
}
