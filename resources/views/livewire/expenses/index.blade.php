<div>
    <x-slide-over x-data="{ show: $wire.entangle('showAddExpenseForm') }">
        <x-page-header>
            Add expense
        </x-page-header>
        <div>
            <form wire:submit.prevent="saveExpense">
                <div class="relative">
                    <div class="flex items-end py-4">
                        <div class="flex-1">
                            <x-input.label for="category">
                                Category
                            </x-input.label>
                            <x-input.select
                                id="category"
                                wire:model.defer="category"
                            >
                                <option value="">Choose</option>
                                @foreach ($expenseCategories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </x-input.select>
                            @error('category')
                                <x-input.error>{{ $message }}</x-input.error>
                            @enderror
                        </div>
                        <button x-on:click.prevent="$wire.set('showExpenseCategoryCreateForm',true)">
                            <x-icons.plus class="w-12 h-12 text-sky-500 hover:text-sky-600" />
                        </button>
                    </div>

                </div>
                <div class="py-4">
                    <x-input.label for="reference">
                        Reference
                    </x-input.label>
                    <x-input.text
                        id="reference"
                        type="text"
                        wire:model.defer="reference"
                    />
                    @error('reference')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-4">
                    <x-input.label for="date">
                        Date
                    </x-input.label>
                    <x-input.text
                        id="date"
                        type="date"
                        wire:model.defer="date"
                    />
                    @error('date')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-4">
                    <x-input.label for="invoice_no">
                        Invoice no
                    </x-input.label>
                    <x-input.text
                        id="invoice_no"
                        type="text"
                        wire:model.defer="invoice_no"
                    />
                    @error('invoice_no')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-4">
                    <x-input.label for="amount">
                        Amount
                    </x-input.label>
                    <x-input.text
                        id="amount"
                        type="number"
                        inputmode="numeric"
                        pattern="[0-9]"
                        step="0.01"
                        wire:model.defer="amount"
                    />
                    @error('amount')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-4">
                    <x-input.label for="vat_number">
                        Vat number
                    </x-input.label>
                    <x-input.text
                        id="vat_number"
                        type="text"
                        wire:model.defer="vat_number"
                    />
                    @error('vat_number')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2 px-2 rounded-md bg-slate-100">
                    <label
                        class="flex items-center space-x-2 text-xs font-medium uppercase"
                        for="taxable"
                    >
                        <input
                            class="rounded-full text-sky-500 focus:ring-slate-200"
                            id="taxable"
                            type="checkbox"
                            wire:model.defer="taxable"
                        />
                        <span class="ml-3">Taxable</span>
                    </label>
                </div>
                <div class="py-4">
                    <button
                        class="button-success"
                        wire:loading.attr="disabled"
                        wire:target="saveExpense"
                    >
                        <x-icons.busy target="saveExpense" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <x-modal x-data="{ show: $wire.entangle('showExpenseCategoryCreateForm') }">
        <x-page-header>
            Add expense category
        </x-page-header>
        <div>
            <form wire:submit.prevent="addCategory">
                <div class="py-2">
                    <x-input.label for="name">
                        Name
                    </x-input.label>
                    <x-input.text
                        id="name"
                        type="text"
                        wire:model.defer="categoryName"
                    />
                    @error('categoryName')
                        <x-input.error>{{ $message }}</x-input.error>
                    @enderror
                </div>
                <div class="py-2">
                    <button class="button-success">
                        <x-icons.busy target="addCategory" />
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-800">
        <!-- Transaction create -->
        <div class="p-2">
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                <div>
                    <x-input.label>
                        Search
                    </x-input.label>
                    <x-input.text
                        type="text"
                        wire:model="searchQuery"
                        placeholder="search by reference"
                    />
                    <x-input.helper>
                        Query Time {{ round($queryTime, 3) }} ms
                    </x-input.helper>
                </div>
                <div></div>
                <div class="flex justify-end">
                    <button
                        class="w-full h-10 lg:w-32 button-success"
                        x-on:click="$wire.set('showAddExpenseForm',true)"
                    >
                        add expense
                    </button>
                </div>
            </div>
        </div>
        <!-- End -->

        <div class="p-2">
            {{ $expenses->links() }}
        </div>

        <div>
            <x-table.container>
                <x-table.header class="hidden lg:grid lg:grid-cols-6">
                    <x-table.heading>Category</x-table.heading>
                    <x-table.heading class="lg:col-span-2">Reference</x-table.heading>
                    <x-table.heading>Invoice no</x-table.heading>
                    <x-table.heading class="text-center">Taxable</x-table.heading>
                    <x-table.heading class="text-right">Amount</x-table.heading>
                </x-table.header>
                @forelse($expenses as $expense)
                    <x-table.body class="grid grid-cols-2 lg:grid-cols-6">
                        <x-table.row class="text-sm text-left">
                            <p>{{ $expense->category }}</p>
                            <p class="lg:hidden"> {{ $expense->invoice_no }}</p>
                            <button
                                class="hidden text-rose-600 lg:block dark:text-rose-400 hover:text-rose-"
                                x-on:click="$wire.call('remove',{{ $expense->id }})"
                            >remove
                            </button>
                        </x-table.row>
                        <x-table.row class="text-sm font-semibold text-left lg:col-span-2">
                            {{ $expense->reference }}
                            <div>
                                <p class="text-xs text-slate-600 dark:text-slate-500">
                                    {{ $expense->date->format('d-m-y') }}</p>
                            </div>
                        </x-table.row>
                        <x-table.row class="hidden text-sm text-left text-center uppercase lg:block">
                            {{ $expense->invoice_no }}
                        </x-table.row>
                        <x-table.row class="col-span-2 text-center lg:col-span-1">
                            @if ($expense->taxable)
                                <div class="px-3 text-center bg-blue-200 rounded pxy-1">
                                    <p class="text-xs text-blue-900">Taxable</p>
                                </div>
                            @else
                                <div class="px-3 text-center bg-rose-200 rounded pxy-1">
                                    <p class="text-xs text-rose-900">Non Taxable</p>
                                </div>
                            @endif
                        </x-table.row>
                        <x-table.row class="col-span-2 text-sm text-center lg:col-span-1 lg:text-right">
                            R {{ number_format($expense->amount, 2) ?? 0 }}
                            @if ($expense->taxable)
                                <div class="text-xs">
                                    (R {{ number_format(vat($expense->amount), 2) ?? 0 }})
                                </div>
                            @endif
                        </x-table.row>
                        <x-table.row class="col-span-2 lg:hidden">
                            <button
                                class="w-full button-danger"
                                x-on:click="$wire.call('remove',{{ $expense->id }})"
                            >remove
                            </button>
                        </x-table.row>
                    </x-table.body>
                @empty
                    <x-table.empty></x-table.empty>
                @endforelse
            </x-table.container>
        </div>
    </div>
</div>
