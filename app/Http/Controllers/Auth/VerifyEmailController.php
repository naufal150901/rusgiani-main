<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Traits\LogsActivity;

class VerifyEmailController extends Controller
{
    use LogsActivity;
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard.index', absolute: false) . '?verified=1')->with('success', 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified() && !$request->session()->has('email_verified_logged')) {
            event(new Verified($request->user()));
            $this->logActivity('Email verified', $request->user());
            $request->session()->put('email_verified_logged', true);
        }

        return redirect()->intended(route('dashboard.index', absolute: false) . '?verified=1')->with('success', 'Email verified successfully.');
    }
}
