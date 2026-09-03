<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutUserAction
{

	/**
	 * Invalidate session and log out current user from a specific guard.
	 */
	public function execute(string $guard = 'web'): void
	{

		Auth::guard($guard)->logout();

		// Forget the specific authentication state key for this guard in session
		session()->forget(Auth::guard($guard)->getName());

		// Regenerate session ID and CSRF token safely
		session()->regenerate();
		session()->regenerateToken();
	}
}
