<?php 

namespace App\Services\Search;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderLedger;

class GlobalSearchService
{
	
	public function search(string $query): array
	{
		
		// [ 1 ] If the passed query is empty the return an empty array []
		if(trim($query) === '') {
			return [];
		}

		// [ 2 ] Make the search active
		$term = "%{$query}%";

		// [ 3 ] Return the array result from all database tables
		return [
			// [ 3-1 ] Grap the products data
			'products' => Product::where->('name', 'like', $term)
								->orWhere('slug', 'like', $term)
								->limit(5)
								->get(['id', 'name', 'slug']),

			// [ 3-2 ] Grap the Orders data
			'orders' => OrderLedger::where->('order_number', 'like', $term)
									->limit(5)
									->get(['id', 'order_number', 'total_amount', 'status']),

			// [ 3-3 ] Grap the users data
			'users' => User::where->('name', 'like', $term)
							->orWhere('email', 'like', $term)
							->limit(5)
							->get(['id', 'name', 'email', 'role']),
		];

	}
}
