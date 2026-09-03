<?php

namespace App\Services\Search;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderLedger;

class GlobalSearchService
{
	/**
	 * Search across products, orders and users.
	 */
	public function search(string $query): array
	{
		/*
        |--------------------------------------------------------------------------
        | Normalize Search Query
        |--------------------------------------------------------------------------
        */

		$query = trim($query);

		/*
        |--------------------------------------------------------------------------
        | Empty Search
        |--------------------------------------------------------------------------
        */

		if ($query === '') {
			return [
				'products' => [],
				'orders'   => [],
				'users'    => [],
			];
		}

		/*
        |--------------------------------------------------------------------------
        | Search Term
        |--------------------------------------------------------------------------
        */

		$term = "%{$query}%";

		/*
        |--------------------------------------------------------------------------
        | Return Search Results
        |--------------------------------------------------------------------------
        */

		return [
			/*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */

			'products' => Product::query()
				->where(function ($query) use ($term) {
					$query
						->where('name', 'like', $term)
						->orWhere('slug', 'like', $term);
				})
				->limit(5)
				->get([
					'id',
					'name',
					'slug',
				]),

			/*
            |--------------------------------------------------------------------------
            | Orders
            |--------------------------------------------------------------------------
            */

			'orders' => OrderLedger::query()
				->where('order_number', 'like', $term)
				->limit(5)
				->get([
					'id',
					'order_number',
					'total_amount',
					'status',
				]),

			/*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

			'users' => User::query()
				->where(function ($query) use ($term) {
					$query
						->where('name', 'like', $term)
						->orWhere('email', 'like', $term);
				})
				->limit(5)
				->get([
					'id',
					'name',
					'email',
					'role',
				]),
		];
	}
}
