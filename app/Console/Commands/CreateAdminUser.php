<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email : Email address for the admin account}';

    protected $description = 'Create an admin account without enabling public registration';

    public function handle(): int
    {
        $email = (string) $this->argument('email');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->components->error('Enter a valid email address.');

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($user?->is_admin) {
            $this->components->info('This account is already an admin.');

            return self::SUCCESS;
        }

        if ($user) {
            if (! $this->confirm('Promote this existing account to admin?', false)) {
                return self::FAILURE;
            }

            $user->is_admin = true;
            $user->save();
        } else {
            $name = trim((string) $this->ask('Admin name'));
            $password = (string) $this->secret('Password (at least 12 characters)');
            $confirmation = (string) $this->secret('Confirm password');

            if ($name === '' || strlen($password) < 12 || $password !== $confirmation) {
                $this->components->error('Provide a name, a matching password, and at least 12 password characters.');

                return self::FAILURE;
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $user->is_admin = true;
            $user->save();
        }

        $this->components->info("Admin account ready for {$email}.");

        return self::SUCCESS;
    }
}
