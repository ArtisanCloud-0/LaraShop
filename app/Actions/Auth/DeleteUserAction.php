<?php

namespace App\Actions\Auth;

use App\Models\User;

class DeleteUserAction {

	public function execute(User $user, User $currentUser): bool
	{

		// [ 1 ] Prevent the user from deleting his account
		if($user->id === $currentUser->id) {
			
			throw new Exception("You cannot delete your own account."); 

		}

		// [ 2 ] Delete the user record
		return $user->delete();
	
	}

}
