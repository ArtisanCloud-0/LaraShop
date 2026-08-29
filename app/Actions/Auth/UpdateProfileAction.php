<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateProfileAction
{
	public function execute(User $user, array $data): User
	{
		$updateData = [
			'name'  => $data['name'],
			'email' => $data['email'],
		];

		if (!empty($data['password'])) {
			$updateData['password'] = Hash::make($data['password']);
		}

		if (isset($data['image']) && $data['image']) {
			// Delete old profile image if exists
			if ($user->image && Storage::disk('public')->exists('profiles/' . $user->image)) {
				Storage::disk('public')->delete('profiles/' . $user->image);
			}

			$updateData['image'] = $data['image'];
		}

		$user->update($updateData);

		return $user;
	}
}
