<?php

namespace App\Services\Settings;

use Illuminate\Support\Facades\Cache;

class SettingsService
{
	
	public function saveSettings(array $settings): void
	{
		Cache::forever('store_settings', $settings);
	}
	
	public function getSettings(): array
	{
		return Cache::get('store_settings', [
            'store_name'     => 'LaraShop',
            'support_email' => 'support@larashop.test',
            'currency'      => 'USD',
            'tax_rate'      => 14.0,
        ]);
	}

}
