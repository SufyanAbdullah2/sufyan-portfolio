<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_authentication(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('admin.login'))->assertOk();
    }

    public function test_regular_users_cannot_access_the_admin_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_only_admin_users_can_sign_in_to_the_admin_area(): void
    {
        Cache::flush();
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'correct-password',
        ]);

        $this->get(route('admin.login'))->assertOk();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ])->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();

        $user->is_admin = true;
        $user->save();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_is_rate_limited(): void
    {
        Cache::flush();

        foreach (range(1, 5) as $attempt) {
            $this->post(route('admin.login.store'), [
                'email' => 'admin@example.com',
                'password' => 'incorrect-password',
            ])->assertRedirect();
        }

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'incorrect-password',
        ])->assertTooManyRequests();
    }

    public function test_admin_login_is_rate_limited_per_ip_across_emails(): void
    {
        Cache::flush();

        foreach (range(1, 5) as $attempt) {
            $this->post(route('admin.login.store'), [
                'email' => "admin{$attempt}@example.com",
                'password' => 'incorrect-password',
            ])->assertRedirect();
        }

        $this->post(route('admin.login.store'), [
            'email' => 'another-admin@example.com',
            'password' => 'incorrect-password',
        ])->assertTooManyRequests();
    }

    public function test_admin_can_create_update_publish_and_delete_projects(): void
    {
        $admin = User::factory()->create();
        $admin->is_admin = true;
        $admin->save();

        $this->actingAs($admin)
            ->get(route('admin.projects.create'))
            ->assertOk()
            ->assertSee('Add a project');

        $this->post(route('admin.projects.store'), [
            'title' => 'A NEW PROJECT',
            'category' => 'DIGITAL EXPERIENCE',
            'description' => 'A thoughtful project description.',
            'image_url' => '/images/projects/new-project.jpg',
            'project_url' => 'https://example.com/project',
            'year' => '2026',
            'sort_order' => 2,
            'is_published' => '1',
        ])->assertRedirect();

        $project = Project::query()->where('title', 'A NEW PROJECT')->firstOrFail();
        $this->assertTrue($project->is_published);
        $this->assertDatabaseHas('projects', ['title' => 'A NEW PROJECT', 'is_published' => true]);

        $this->put(route('admin.projects.update', $project), [
            'title' => 'A QUIETER PROJECT',
            'category' => 'WEB',
            'description' => 'Updated project description.',
            'image_url' => '/images/projects/new-project.jpg',
            'project_url' => '',
            'year' => '2025',
            'sort_order' => 1,
        ])->assertRedirect();

        $this->assertDatabaseHas('projects', ['title' => 'A QUIETER PROJECT', 'is_published' => false]);

        $this->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_project_urls_reject_non_http_schemes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.projects.store'), [
                'title' => 'UNSAFE LINK',
                'category' => 'WEB',
                'description' => 'A project with an unsafe URL.',
                'project_url' => 'javascript:alert(1)',
                'sort_order' => 1,
            ])
            ->assertSessionHasErrors('project_url');

        $this->assertDatabaseMissing('projects', ['title' => 'UNSAFE LINK']);
    }

    public function test_admin_can_read_and_delete_contact_messages(): void
    {
        $admin = User::factory()->create();
        $admin->is_admin = true;
        $admin->save();

        $message = ContactMessage::create([
            'name' => 'A Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'A little idea',
            'message' => 'I have an idea for a website.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('A Visitor')
            ->assertSee('A little idea');

        $this->get(route('admin.messages.show', $message))
            ->assertOk()
            ->assertSee('I have an idea for a website.');

        $this->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
