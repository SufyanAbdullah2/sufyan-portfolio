<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:password {email : Email address for the admin account}';

    protected $description = 'Reset an admin password securely from the command line';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $admin = User::query()->where('email', $email)->where('is_admin', true)->first();

        if (! $admin) {
            $this->components->error('No admin account was found for that email address.');

            return self::FAILURE;
        }

        $password = (string) $this->secret('New password (at least 12 characters)');
        $confirmation = (string) $this->secret('Confirm new password');

        if (strlen($password) < 12 || $password !== $confirmation) {
            $this->components->error('Provide matching passwords with at least 12 characters.');

            return self::FAILURE;
        }

        $admin->password = $password;
        $admin->save();

        $this->components->info('Admin password updated.');

        return self::SUCCESS;
    }
}
