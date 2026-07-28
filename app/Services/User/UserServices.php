<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserServices {

	public function getAdminUsers(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->whereIn('role', ['admin', 'super_admin'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);
    }

}
