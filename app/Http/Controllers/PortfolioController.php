<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('portfolio.index', compact('projects'));
    }

    public function contact(Request $request): RedirectResponse
    {
        // Honeypot: bots often fill hidden fields. Return a generic success.
        if ($request->filled('website')) {
            return back()->with('contact_success', 'Thanks. Your message has been received.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website' => ['nullable', 'max:0'],
        ]);

        $normalizedEmail = Str::lower(trim($validated['email']));
        $recentMessageExists = ContactMessage::query()
            ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
            ->where('created_at', '>=', now()->subDay())
            ->exists();
        $emailLimitKey = 'contact-email:'.hash_hmac('sha256', $normalizedEmail, (string) config('app.key'));

        if ($recentMessageExists || ! Cache::add($emailLimitKey, true, now()->addDay())) {
            return back()
                ->withErrors(['email' => 'You can send another message from this email in 24 hours.'])
                ->withInput();
        }

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $normalizedEmail,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
        ]);

        $notificationEmail = config('portfolio.contact_notification_email');

        if ($notificationEmail) {
            Mail::to($notificationEmail)->send(new ContactMessageReceived($contactMessage));
        } else {
            Log::warning('Contact message saved without an email notification because CONTACT_NOTIFICATION_EMAIL is not configured.');
        }

        return back()->with('contact_success', 'Message received. I’ll get back to you soon.');
    }
}
