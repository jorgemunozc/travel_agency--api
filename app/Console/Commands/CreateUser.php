<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateUser extends Command
{
    protected $signature = 'app:create-user {email : Unique email of the user.} {password? : Password for the new user.}
        {--role=normal : Role which the system will assign the permissions for the user.}';

    protected $description = 'Create a user in the DB.';

    public function handle(User $user): void
    {
        DB::beginTransaction();
        try {
            $user->createNewUser($this->argument('email'), $this->argument('password'))
                ->addRole(Roles::tryFrom($this->option('role')) ?? Roles::Normal);
            DB::commit();
            $this->info('User created successfully.');
        } catch (\InvalidArgumentException $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }

    }
}
