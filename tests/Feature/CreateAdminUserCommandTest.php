<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_an_admin_without_public_registration(): void
    {
        $this->artisan('admin:create', ['email' => 'admin@example.com'])
            ->expectsQuestion('Admin name', 'Portfolio Admin')
            ->expectsQuestion('Password (at least 12 characters)', 'a-strong-password-123')
            ->expectsQuestion('Confirm password', 'a-strong-password-123')
            ->assertExitCode(0);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->assertTrue($admin->is_admin);
        $this->assertTrue(Hash::check('a-strong-password-123', $admin->password));
    }

    public function test_command_resets_an_existing_admin_password_without_echoing_it(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $this->artisan('admin:password', ['email' => $admin->email])
            ->expectsQuestion('New password (at least 12 characters)', 'another-strong-password-456')
            ->expectsQuestion('Confirm new password', 'another-strong-password-456')
            ->expectsOutputToContain('Admin password updated.')
            ->doesntExpectOutputToContain('another-strong-password-456')
            ->assertExitCode(0);

        $admin->refresh();

        $this->assertTrue(Hash::check('another-strong-password-456', $admin->password));
    }

    public function test_password_reset_command_does_not_change_non_admin_accounts(): void
    {
        $user = User::factory()->create(['email' => 'member@example.com']);
        $originalPassword = $user->password;

        $this->artisan('admin:password', ['email' => $user->email])
            ->expectsOutputToContain('No admin account was found')
            ->assertExitCode(1);

        $this->assertSame($originalPassword, $user->fresh()->password);
    }
}
