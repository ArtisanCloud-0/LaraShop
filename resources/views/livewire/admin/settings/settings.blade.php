<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-600 dark:text-white">Store Settings</h1>
        <p class="text-xs text-slate-500/80 dark:text-slate-400">Configure global metadata and parameters for LaraShop.</p>
    </div>

    <x-message.session></x-message.session>
    
    <form wire:submit.prevent="save" class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700/60 rounded-2xl p-6 shadow-xl space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Store Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Store Name</label>
                <input 
                    type="text" 
                    wire:model="storeName"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="LaraShop"
                >
            </div>

            <!-- Support Email -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Support Email</label>
                <input 
                    type="email" 
                    wire:model="supportEmail"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="support@larashop.test"
                >
            </div>

            <!-- Default Currency -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Default Currency</label>
                <select 
                    wire:model="currency"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
                    <option value="USD">USD ($)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="EGP">EGP (E£)</option>
                </select>
            </div>

            <!-- Tax Rate (%) -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Default Tax Rate (%)</label>
                <input 
                    type="number" 
                    step="0.01" 
                    wire:model="taxRate"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="14.00"
                >
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex justify-end pt-4 border-t border-slate-700/50">
            <button 
                type="submit" 
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20"
            >
                Update Settings
            </button>
        </div>
    </form>
</div>
