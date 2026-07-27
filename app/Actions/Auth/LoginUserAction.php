<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserAction {
	
	/**
     * Attempt to authenticate a user and return the appropriate redirect route.
     *
     * @throws ValidationException
    */
    public function execute(string $email, string $password, bool $remember = false, string $guard = 'web'): string
    {

    	// [ 1 ] Attempt to login on the required guard
    	if( !Auth::guard($guard)->attempt(['email' => $email, 'password' => $password], $remember) ) {
    		throw ValidationException::withMessages([
    			'email' => __('Authentication Failed.')
    		]); 
    	}

    	// [ 2 ] Grap the user data upon guard
    	$user = Auth::guard($guard)->user();

    	// [ 3 ] Inforce admin role if the loggin to panel guard
    	if($guard === 'panel' && !$user->isAdmin()) {

    		// [ 3-1 ] Logout immediately to destroy invalid admin session
    		Auth::guard($guard)->logout();

    		// [ 3-2 ] Tell the user the hard reality :-) 
    		throw ValidationException::withMessages([
                'email' => 'You do not have administrative access privileges.',
            ]);

    	}

    	// [ 4 ] Generate the valid user session [Prevent Session Fixation]
    	session()->regenerate();

    	// [ 5 ] Return correct redirect route based on guard
    	return $guard === 'panel' ? route('dashboard') : redirect()->intended(route('home'))->getTargetUrl();

    }

}
