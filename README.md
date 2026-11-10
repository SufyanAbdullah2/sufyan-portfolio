# SUFYAN® — Laravel Creative Developer Portfolio

A dark, motion-led personal portfolio starter built for Laravel 13 + Blade + Vite.

## Requirements
- PHP 8.3+
- Composer
- Node.js + npm
- MySQL or SQLite

## 1. Create the Laravel app
```bash
composer create-project laravel/laravel sufyan-portfolio
cd sufyan-portfolio
```
Choose Laravel 13 if prompted. Then copy the contents of this starter ZIP into the Laravel project, keeping the same folder structure and allowing files to merge/replace.

## 2. Configure database
For MySQL, create a database named `sufyan_portfolio`, then update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sufyan_portfolio
DB_USERNAME=root
DB_PASSWORD=
```
SQLite is also fine; use Laravel's default SQLite setup.

## 3. Install frontend dependencies
The starter uses GSAP from npm:
```bash
npm install
npm install gsap
```
Make sure your `vite.config.js` has the Laravel Vite plugin and the CSS/JS entry points:
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## 4. Run migrations and seed sample projects
```bash
php artisan migrate --seed
```

## 5. Run the app
```bash
npm run dev
php artisan serve
```
Open http://127.0.0.1:8000

## Included
- Responsive portfolio landing page
- GSAP entrance, reveal, counter and magnetic-style button motion
- Mobile navigation
- Projects loaded from database
- Password-protected admin area for managing projects and contact messages
- Contact form with server-side validation, spam honeypot, database storage, and email notifications
- Contact protection with a five-per-minute IP limit and one accepted message per normalized email every 24 hours
- Rate-limited admin sign-in and standard browser security headers
- Branded error pages for common client and server errors
- SEO basics, reduced-motion support, accessible labels

## Admin and contact notifications
After running migrations, create an admin account from the terminal:
```bash
php artisan admin:create you@example.com
```
The command asks for a name and a private password; public registration is not enabled. Sign in at `/admin`.

Set `CONTACT_NOTIFICATION_EMAIL` in `.env` to the inbox that should receive contact-form submissions. Configure Laravel's `MAIL_*` settings with your mail provider's SMTP credentials in `.env`; keep credentials out of source control. In local development the example mailer uses `log`, so messages are written to the Laravel log instead of being delivered to an inbox.

For Gmail, use an App Password (Google account 2-Step Verification must be enabled) and configure these local `.env` values:
```env
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail-address
MAIL_PASSWORD=your-google-app-password
MAIL_FROM_ADDRESS=your-gmail-address
```
Never use your regular Gmail password or commit the App Password.

The contact form accepts one message per normalized email address within 24 hours, plus a five-request-per-minute IP limit. Admin sign-in is limited by both IP and normalized email. Use a shared Redis or database cache store in production so limits are consistent across app servers.

If you forget the admin password, reset it from the server terminal; the new password is entered through hidden prompts and is never placed in the command arguments:
```bash
php artisan admin:password you@example.com
```

## Production launch checklist
- Set `APP_ENV=production`, `APP_DEBUG=false`, and `APP_URL` to the final HTTPS domain in the hosting provider's secret/environment settings.
- Configure SMTP and `CONTACT_NOTIFICATION_EMAIL` there, then submit a real contact-form test and confirm it reaches the inbox. Never commit production credentials.
- Use a shared database or Redis cache store for rate limits; enable HTTPS and secure session cookies at the host.
- Build frontend assets and run migrations during deployment (`npm ci && npm run build`, then `php artisan migrate --force`); keep database backups and error monitoring enabled.
- Verify `/robots.txt`, `/sitemap.xml`, `/up`, contact delivery, and admin sign-in on the live domain.

The portfolio publishes a sitemap containing its single public page. The admin and sign-in paths are excluded from crawling and carry `noindex`; these crawler directives are not access controls.

## Free Render demo deployment

This optional setup keeps the Laravel backend and uses the free Render web-service plan with a free Supabase PostgreSQL database. It is suitable for a portfolio demo, not a reliability-sensitive production service:
- Render sleeps after 15 minutes without traffic; the first request after sleep can take about a minute. Free service files are temporary, so the app uses PostgreSQL for sessions, cache, and portfolio data.
- Supabase free databases can pause after a week without activity. Check the provider dashboard and resume the project if needed.
- Render blocks outbound SMTP ports, so contact messages are saved for the admin panel but inbox notifications are not delivered on this free setup.
- Free-plan quotas can suspend service/builds when exhausted. Do not add a payment method unless you explicitly want paid usage.

The repo includes a `render.yaml` Blueprint and Docker configuration. To deploy:
1. Create a Supabase free project near Singapore and use its session-pooler connection details (host, port, database, username, and password). Do not put database credentials in Git.
2. Make sure the GitHub repo contains the latest portfolio code, then create a Render Blueprint from that repo and review that the web service plan is `free`. The Blueprint generates `APP_KEY`; enter the Supabase database values only into Render's private environment-variable prompts.
3. After the first successful deployment, set up the admin against the same Supabase database: temporarily point the local `.env` database variables at Supabase, run `php artisan admin:create you@example.com`, then restore the local database settings. Never put the admin password in a command argument or chat.
4. Open the Render `onrender.com` URL, test the contact form and admin sign-in, and use that public URL for SetRepo's URL scan. A clean URL scan does not replace code review or dependency audits.

This workspace currently has no Git repository configured, so these deployment files are prepared locally; publishing them to GitHub and connecting Render still requires your own account access. No hosting resources or paid services have been created.

## Customize
Edit `resources/views/portfolio/index.blade.php` for your intro, socials and bio.
Edit `database/seeders/ProjectSeeder.php` for your project titles, descriptions and preview images.
Keep local preview images in `public/images/projects` and reference them with `/images/projects/filename`.
Set `APP_URL` correctly before production deployment.

## Important
The Lagunitas IPA showcase is an independent concept, not an official brand site. Replace the sample contact details before publishing. For production, configure mail delivery, rate limiting, HTTPS, backups and error monitoring.
