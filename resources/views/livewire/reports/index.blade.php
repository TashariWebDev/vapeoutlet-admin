<div>

    @php
        function check_file_exist($url)
        {
            $handle = @fopen($url, 'r');
            if (!$handle) {
                return false;
            } else {
                return true;
            }
        }
    @endphp

    <div>
        @php
            $credits = $transactions->total_refunds + $transactions->total_credits;
            $gross_sales = $transactions->total_sales + $credits;
        @endphp

        <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Sales</h3>
                <x-slot:footer>
                    <div class="flex items-baseline space-x-3">
                        <p class="font-bold text-teal-500">
                            {{ number_format(to_rands($gross_sales), 2) ?? '0.00' }}
                        </p>
                        <p class="text-sm text-teal-500">
                            {{ number_format(to_rands(ex_vat($gross_sales)), 2) ?? '0.00' }} (ex vat)
                        </p>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Purchases</h3>
                <x-slot:footer>
                    <div class="flex items-baseline space-x-3">
                        <p class="font-bold text-teal-500">
                            {{ number_format(to_rands($purchases->total_purchases), 2) }}
                        </p>
                        <p class="text-sm text-teal-500">
                            {{ number_format(to_rands(ex_vat($purchases->total_purchases)), 2) }} (ex vat)
                        </p>
                    </div>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Expenses</h3>
                <x-slot:footer>
                    <p class="font-bold text-teal-500">
                        {{ number_format(to_rands($expenses->total_expenses), 2) ?? '0.00' }}
                    </p>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Refunds</h3>
                <x-slot:footer>
                    <p class="font-bold text-teal-500">
                        {{ number_format(to_rands($transactions->total_refunds), 2) ?? '0.00' }}
                    </p>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Credits</h3>
                <x-slot:footer>
                    <p class="font-bold text-teal-500">
                        {{ number_format(to_rands($transactions->total_credits), 2) ?? '0.00' }}
                    </p>
                </x-slot:footer>
            </x-stat-container>

            <x-stat-container>
                <h3 class="text-lg font-bold leading-6 text-slate-500 dark:text-slate-400">Stock value</h3>
                <x-slot:footer>
                    <div class="flex justify-between items-center">
                        <div class="flex items-baseline space-x-3">
                            <p class="font-bold text-teal-500">
                                {{ number_format(to_rands($this->stockValue), 2) ?? '0.00' }}
                            </p>
                            <p class="text-sm text-teal-500">
                                {{ number_format(to_rands(ex_vat($this->stockValue)), 2) ?? '0.00' }} (ex vat)
                            </p>
                        </div>
                        <button wire:click="getStockValue">
                            <x-icons.refresh
                                class="w-4 h-4 text-teal-500"
                                wire:target="getStockValue"
                                wire:loading.class="animate-spin-slow"
                            />
                        </button>
                    </div>
                </x-slot:footer>
            </x-stat-container>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 py-6 lg:grid-cols-3">

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.debtor-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.creditors-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.expense-report />

        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.purchase-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.credit-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.variances-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.sales-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <livewire:reports.stock-report />
        </div>

        <div class="p-2 bg-white rounded-md dark:bg-slate-800">
            <button
                class="w-full button-success"
                x-on:click="@this.set('showStockTakeModal',true)"
            >Create stock take
            </button>

            <div class="py-4">
                <a
                    class="link"
                    href="{{ route('stock-takes') }}"
                >Stock Takes</a>
            </div>

            <x-modal x-data="{ show: $wire.entangle('showStockTakeModal') }">
                <form wire:submit.prevent="createStockTake">
                    <div class="overflow-y-scroll p-3 h-72 border shadow-inner">
                        @foreach ($this->brands as $brand)
                            <div class="p-1 mb-1 w-full text-xs rounded bg-slate-100">
                                <label>
                                    <input
                                        type="checkbox"
                                        value="{{ $brand->name }}"
                                        wire:model.defer="selectedBrands"
                                    >
                                </label>{{ $brand->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <button class="button-success">Create</button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>

</div>
