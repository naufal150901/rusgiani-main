<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\LogsActivity;

class EmailVerificationPromptController extends Controller
{
    use LogsActivity;
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail() && !$request->session()->has('email_verified_logged')) {
            $this->logActivity('Email verified', $request->user());
            $request->session()->put('email_verified_logged', true);
        }
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard.index', absolute: false))->with('success', 'Your email has been verified.')
            : view('auth.verify-email', [
                'title' => 'Verify Email',
            ]);
    }
}
