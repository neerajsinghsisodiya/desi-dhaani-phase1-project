<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $resetLink = null;
        if (app()->isLocal() && config('mail.default') === 'log' && ($user = User::where('email', $request->email)->first())) {
            $token = Password::broker()->createToken($user);
            $user->sendPasswordResetNotification($token);
            $resetLink = route('password.reset', ['token' => $token, 'email' => $user->email]);
            $status = Password::RESET_LINK_SENT;
        } else {
            $status = Password::sendResetLink($request->only('email'));
        }

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))->with('reset_link', $resetLink)
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
