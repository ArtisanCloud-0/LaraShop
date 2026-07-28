<?php

namespace App\Actions\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{

    // Registering new users [Admins && Customers]
    public function execute(array $data, ?User $user = null, string $defaultRole = 'customer'): User
    {

        // [ 1 ] If the current user is passed then use it [Updated Current User], if not exsist [Create new User]
        $user = $user ?? new User();

        // [ 2 ] Set the data that comes from the form into user model
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'] ?? $defaultRole; // Assign the role (explicitly from array if present, otherwise default)

        if(!empty($data['password'])) {
            $user->password = Hash::make($data['password']); // Hashing the password 
        } elseif (!$user->exists) {
            // Unused random password for unauthenticated guest checkouts
            $user->password = Hash::make(Str::random(32));
        } else {}

        // [ 3 ] Save the new user record or update the exsisting one
        $user->save();

        // [ 4 ] Return the user record
        return $user;

    }

}
