<div>
    <x-slide-over title="Add expense" wire:model.defer="showAddExpenseForm">
        <div>
            <form wire:submit.prevent="saveExpense">
                <div class="relative">
                    <div class="absolute right-0 pt-0.5 z-10">
                        <button x-on:click.prevent="@this.set('showExpenseCategoryCreateForm',true)">
                            <x-icons.plus class="text-green-500 hover:text-green-600 w-12 h-12"/>
                        </button>
                    </div>
                    <div class="py-4">
                        <x-select wire:model.defer="category" label="Select a category">
                            @foreach($expenseCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                </div>
                <div class="py-4">
                    <x-input type="text" wire:model.defer="reference" label="Reference"/>
                </div>
                <div class="py-4">
                    <x-input type="date" wire:model.defer="date" label="Invoice date"/>
                </div>
                <div class="py-4">
                    <x-input type="text" wire:model.defer="invoice_no" label="Invoice number"/>
                </div>
                <div class="py-4">
                    <x-input-number type="number" wire:model.defer="amount"
                                    label="Invoice amount"/>
                </div>
                <div class="py-4">
                    <x-input type="text" wire:model.defer="vat_number" label="Vat Number"/>
                </div>
                <div class="py-2 bg-gray-100 rounded-md px-2">
                    <label for="taxable" class="text-xs uppercase font-medium flex items-center space-x-2">
                        <input type="checkbox" wire:model.defer="taxable" id="taxable"
                               class="rounded-full text-green-500 focus:ring-gray-200"/>
                        <span class="ml-3">Taxable</span>
                    </label>
                </div>
                <div class="py-4">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-slide-over>

    <x-modal wire:model.defer="showExpenseCategoryCreateForm" title="Add expense category">
        <div>
            <form wire:submit.prevent="addCategory">
                <div class="py-2">
                    <x-input type="text" wire:model.defer="categoryName" label="Name"/>
                </div>
                <div class="py-2">
                    <button class="button-success">
                        <x-icons.save class="w-5 h-5 mr-2"/>
                        save
                    </button>
                </div>
            </form>
        </div>
    </x-modal>


    <!-- Transaction create -->
    <div class="p-4">
        <div class="flex flex-wrap items-center lg:justify-between space-y-2 lg:space-y-0 lg:space-x-2">
            <x-inputs.search type="text" wire:model="searchTerm"
                             placeholder="search by reference"/>

            <div>
                <button class="button-success w-full lg:w-72" x-on:click="@this.set('showAddExpenseForm',true)">
                    <x-icons.plus class="w-5 w-5 mr-2"/>
                    add expense
                </button>
            </div>
        </div>
    </div>
    <!-- End -->


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
                <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
                    <x-table.row class="text-center lg:text-left text-sm">
                        <p>{{$expense->category}}</p>
                        <button class="text-red-600 hover:text-red-700"
                                x-on:click="@this.call('remove',{{ $expense->id}})"
                        >remove
                        </button>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-left lg:col-span-2 text-sm font-semibold">
                        {{ $expense->reference }}
                        <div>
                            <p class="text-xs text-gray-600">{{ $expense->date->format('Y-m-d') }}</p>
                        </div>
                    </x-table.row>
                    <x-table.row class="text-center lg:text-left uppercase text-sm">
                        {{ $expense->invoice_no }}
                    </x-table.row>
                    <x-table.row class="flex justify-center">
                        @if($expense->taxable)
                            <x-icons.tick class="w-5 h-5 text-green-600"/>
                        @else
                            <x-icons.cross class="w-5 h-5 text-red-600"/>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center lg:text-right text-sm">
                        R {{ number_format($expense->amount,2) ?? 0 }}
                        @if($expense->taxable)
                            <div class="text-xs">
                                (R {{ number_format(vat($expense->amount),2) ?? 0 }})
                            </div>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
    <div>
        {{ $expenses->links() }}
    </div>
</div>
