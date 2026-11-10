<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Project;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_published_projects(): void
    {
        Project::create([
            'title' => 'VISIBLE PROJECT',
            'category' => 'WEB',
            'description' => 'A published test project.',
            'is_published' => true,
        ]);

        Project::create([
            'title' => 'HIDDEN PROJECT',
            'category' => 'WEB',
            'description' => 'An unpublished test project.',
            'is_published' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('VISIBLE PROJECT')
            ->assertDontSee('HIDDEN PROJECT');
    }

    public function test_homepage_features_the_uploaded_projects_instead_of_demo_content(): void
    {
        Project::create([
            'title' => 'NORTHSTAR',
            'category' => 'DIGITAL EXPERIENCE',
            'description' => 'A demo project being replaced.',
            'is_published' => true,
        ]);

        $this->seed(ProjectSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('LAGUNITAS IPA')
            ->assertSeeText('STUDIOVA')
            ->assertSee('images/projects/lagunitas-can.png')
            ->assertSee('images/projects/studiova-services-img-1.jpg')
            ->assertDontSeeText('NORTHSTAR');

        $this->assertDatabaseHas('projects', [
            'title' => 'NORTHSTAR',
            'is_published' => false,
        ]);

        $this->assertFileExists(public_path('images/projects/lagunitas-can.png'));
        $this->assertFileExists(public_path('images/projects/studiova-services-img-1.jpg'));
    }

    public function test_contact_form_stores_valid_message(): void
    {
        Mail::fake();
        config()->set('portfolio.contact_notification_email', 'sufyan@example.com');

        $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Project inquiry',
            'message' => 'I would like to discuss a website project.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        Mail::assertSent(ContactMessageReceived::class);
    }

    public function test_same_email_cannot_submit_another_message_for_24_hours(): void
    {
        Mail::fake();
        config()->set('portfolio.contact_notification_email', 'sufyan@example.com');

        $payload = [
            'name' => 'Test User',
            'email' => 'Test@Example.com',
            'subject' => 'Project inquiry',
            'message' => 'I would like to discuss a website project.',
        ];

        $this->post('/contact', $payload)->assertRedirect();
        Cache::flush();

        $this->post('/contact', [...$payload, 'email' => 'test@example.com'])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'email' => 'You can send another message from this email in 24 hours.',
            ]);

        $this->assertDatabaseCount('contact_messages', 1);
        Mail::assertSentCount(1);

        $this->travelTo(now()->addHours(24)->addSecond());

        $this->post('/contact', [...$payload, 'email' => 'test@example.com'])->assertRedirect();

        $this->assertDatabaseCount('contact_messages', 2);
        Mail::assertSentCount(2);
    }

    public function test_contact_form_does_not_store_or_email_honeypot_submissions(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'This is a bot submission.',
            'website' => 'https://spam.example',
        ])->assertRedirect()->assertSessionHas('contact_success');

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_contact_form_is_rate_limited_per_ip(): void
    {
        Cache::flush();

        foreach (range(1, 5) as $attempt) {
            $this->post('/contact', [])->assertRedirect();
        }

        $this->post('/contact', [])->assertTooManyRequests();

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_sensitive_responses_include_security_headers(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_robots_and_sitemap_only_expose_the_public_portfolio(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSeeText('Disallow: /admin')
            ->assertSeeText(rtrim((string) config('app.url'), '/').'/sitemap.xml');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(rtrim((string) config('app.url'), '/').'/', false)
            ->assertDontSee('/admin', false);
    }

    public function test_admin_sign_in_page_is_excluded_from_search_indexing(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
    }

    public function test_custom_error_pages_render_for_common_http_statuses(): void
    {
        Route::get('/__test-errors/{status}', fn (string $status) => abort((int) $status));

        $pages = [
            400 => 'REQUEST ERROR',
            401 => 'SIGN IN REQUIRED',
            403 => 'ACCESS DENIED',
            404 => 'PAGE NOT FOUND',
            419 => 'PAGE EXPIRED',
            429 => 'TOO MANY REQUESTS',
            500 => 'INTERNAL SERVER ERROR',
            501 => 'SERVER ERROR',
            503 => 'TEMPORARILY UNAVAILABLE',
        ];

        foreach ($pages as $status => $heading) {
            $this->get('/__test-errors/'.$status)
                ->assertStatus($status)
                ->assertSeeText($heading)
                ->assertSee('BACK TO HOME')
                ->assertDontSee('Stack trace');
        }
    }

    public function test_contact_notification_escapes_visitor_supplied_html(): void
    {
        $message = ContactMessage::create([
            'name' => '<script>alert("name")</script>',
            'email' => 'visitor@example.com',
            'subject' => 'A note',
            'message' => '<script>alert("message")</script>',
        ]);

        $html = (new ContactMessageReceived($message))->render();

        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringNotContainsString('<script>alert("message")</script>', $html);
    }
}
