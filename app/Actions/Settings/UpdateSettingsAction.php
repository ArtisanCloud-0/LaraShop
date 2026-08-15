<?php 

namespace App\Actions\Settings;

use App\Services\Settings\SettingsService;

class UpdateSettingsAction
{
    public function __construct(protected SettingsService $settingsService) {}

    public function execute(array $data): void
    {
        $this->settingsService->saveSettings($data);
    }
}