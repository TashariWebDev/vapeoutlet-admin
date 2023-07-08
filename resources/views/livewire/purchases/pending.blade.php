<div>
    <div>
        <x-page-header class="pb-3">
            Pending Purchases
        </x-page-header>

        <div class="bg-white rounded-md shadow-sm dark:bg-slate-900">
            <x-table.container>
                <x-table.header class="hidden grid-cols-4 lg:grid">
                    <x-table.heading>ID</x-table.heading>
                    <x-table.heading>Supplier</x-table.heading>
                    <x-table.heading>Invoice number</x-table.heading>
                    <x-table.heading class="text-right">Action</x-table.heading>
                </x-table.header>
                @foreach ($purchases as $purchase)
                    <x-table.body class="grid grid-cols-1 lg:grid-cols-4">
                        <x-table.row>{{ $purchase->id }}</x-table.row>
                        <x-table.row>{{ $purchase->supplier->name }}</x-table.row>
                        <x-table.row>
                            {{ $purchase->invoice_no }}
                            <p>{{ $purchase->created_at }}</p>
                        </x-table.row>
                        <x-table.row class="text-right">
                            <a href="{{ route('purchases/edit', $purchase->id) }}"
                               class="w-full lg:w-32 button-success"
                            >Edit</a>
                        </x-table.row>
                    </x-table.body>
                @endforeach
            </x-table.container>
        </div>

    </div>

</div>
