<?php 

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
	
	// Update the user main data
	public function updateProfile(User $user, array $data): User
	{
		
		// [ 1 ] Update the current user by the passed data
		$user->update([
			'name' => $data['name'],
			'email' => $data['email'],
		]);

		// [ 2 ] Return the update user data
		return $user;

	}

	// Update the user password
	public function updatePassword(User $user, string $newPassword): void
	{
		
		$user->update([
			'password' => Hash::make($newPassword)
		]);

	}

}