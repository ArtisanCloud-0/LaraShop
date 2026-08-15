<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

use App\Services\Settings\SettingsService;

use App\Actions\Settings\UpdateSettingsAction;

class Settings extends Component
{

    public string $storeName = '';
    public string $supportEmail = '';
    public string $currency = 'USD';
    public float $taxRate = 0.0;

    public function mount(SettingsService $service)
    {
        $settings = $service->getSettings();

        $this->storeName    = $settings['store_name'] ?? '';
        $this->supportEmail = $settings['support_email'] ?? '';
        $this->currency     = $settings['currency'] ?? 'USD';
        $this->taxRate      = $settings['tax_rate'] ?? 0.0;
    }

    public function save(UpdateSettingsAction $action)
    {
        $action->execute([
            'store_name'     => $this->storeName,
            'support_email' => $this->supportEmail,
            'currency'      => $this->currency,
            'tax_rate'      => $this->taxRate,
        ]);

        session()->flash('status', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.settings');
    }

}
