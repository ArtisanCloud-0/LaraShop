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
	
		// [ 1 ] Logout the specific guard ('panel' || 'web')
		Auth::guard($guard)->logout();

		// [ 2 ] Clear out session data associated with this request
		session()->invalidate();

		// [ 3 ] Regenerate CSRF token for security
		session()->regenerateToken();
	
	}
}
