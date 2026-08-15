<?php 

namespace App\Actions\Auth;

use App\Models\User;

use App\Services\User\ProfileService;

class UpdateProfileAction
{
	
	public function __construct(protected ProfileService $profileService) {}

	public function execute(User $user, array $data): User
	{
		
		// [ 1-1 ] Update the password
		if(!empty($data['password'])) {
			$this->profileService->updatePassword($user, $data['password']);
		}

		// [ 1-2 ] Update user data
		return $this->profileService->updateProfile($user, $data);

	}

}
