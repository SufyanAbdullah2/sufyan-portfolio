<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', fn (User $user): bool => $user->is_admin === true);

        $trustedProxies = config('app.trusted_proxies');

        if ($trustedProxies) {
            TrustProxies::at($trustedProxies);
            TrustProxies::withHeaders(
                Request::HEADER_X_FORWARDED_FOR
                    | Request::HEADER_X_FORWARDED_PROTO
                    | Request::HEADER_X_FORWARDED_PORT,
            );
        }

        RateLimiter::for('contact', function (Request $request): Limit {
            return Limit::perMinute(5)->by('contact-ip:'.$request->ip());
        });

        RateLimiter::for('admin-login', function (Request $request): array {
            $email = Str::lower(trim((string) $request->input('email')));
            $emailKey = hash_hmac('sha256', $email, (string) config('app.key'));

            return [
                Limit::perMinute(5)->by('admin-login-ip:'.$request->ip()),
                Limit::perMinute(5)->by('admin-login-email:'.$emailKey),
            ];
        });
    }
}
