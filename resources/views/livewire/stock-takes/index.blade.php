<div>

    <x-modal x-data="{ show: $wire.entangle('showStockTakeModal') }">
        <div class="py-6">
            <form wire:submit.prevent="createStockTake">

                <div class="pb-4">
                    <button
                        class="text-slate-500"
                        wire:click.prevent="selectAllBrands"
                    >Select All
                    </button>

                    @if (!empty($selectedBrands))
                        <button
                            class="text-slate-500"
                            wire:click.prevent="$set('selectedBrands',[])"
                        >Deselect All
                        </button>
                    @endif
                </div>

                <div class="overflow-y-scroll h-72 border shadow-inner border-slate-800">
                    @foreach ($this->brands as $brand)
                        <div
                            class="py-2 px-1 mb-1 w-full text-xs rounded dark:text-white bg-slate-100 text-slate-800 dark:bg-sky-700"
                        >
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
                <div class="pt-4">
                    <x-input.label>
                        Select a Sales Channel
                    </x-input.label>
                    <x-input.select wire:model="salesChannelId">
                        @foreach ($this->salesChannels as $salesChannel)
                            <option value="{{ $salesChannel->id }}">{{ $salesChannel->name }}</option>
                        @endforeach
                    </x-input.select>

                </div>
                <div class="mt-2">
                    <button class="button-success">Create</button>
                </div>
            </form>
        </div>
    </x-modal>

    <div class="px-2 bg-white rounded-lg shadow dark:bg-slate-900">
        <div class="py-3">
            <div class="grid grid-cols-1 lg:grid-cols-3">
                <div>

                    <x-input.text
                        type="search"
                        placeholder="search"
                        autofocus
                        wire:model="searchQuery"
                    />
                </div>

                <div class="text-right">
                    <x-input.label>
                    </x-input.label>
                    @if ($this->isProcessed)
                        <button
                            class="button-success"
                            wire:click.prevent="$toggle('isProcessed')"
                        >Show Not Processed
                        </button>
                    @else
                        <button
                            class="button-success"
                            wire:click.prevent="$toggle('isProcessed')"
                        >Show Processed
                        </button>
                    @endif
                </div>

                <div class="text-right">
                    <x-input.label>
                    </x-input.label>
                    <button
                        class="button-success"
                        x-on:click="@this.set('showStockTakeModal',true)"
                    >Create stock take
                    </button>
                </div>

            </div>
            <div class="py-6">
                {{ $stockTakes->links() }}
            </div>
        </div>

        <x-table.container>
            <x-table.header class="hidden lg:grid lg:grid-cols-6">
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>DATE</x-table.heading>
                <x-table.heading>BRAND</x-table.heading>
                <x-table.heading>CREATED BY</x-table.heading>
                <x-table.heading>COUNT SHEET</x-table.heading>
                <x-table.heading class="text-center">print</x-table.heading>
            </x-table.header>
            @forelse($stockTakes as $stockTake)
                <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
                    <x-table.row>
                        <a
                            class="link"
                            href="{{ route('stock-takes/show', $stockTake->id) }}"
                        >{{ $stockTake->id }}</a>
                    </x-table.row>
                    <x-table.row>
                        <p>{{ $stockTake->date }}</p>
                    </x-table.row>
                    <x-table.row>
                        <p class="uppercase">{{ $stockTake->brand }}</p>
                        <p class="font-bold">{{ $stockTake->sales_channel?->name }}</p>
                    </x-table.row>
                    <x-table.row>
                        <p>{{ $stockTake->created_by }}</p>
                    </x-table.row>
                    <x-table.row>
                        @if ($stockTake->processed_at)
                            <div>
                                <p>PROCESSED</p>
                            </div>
                        @else
                            <button
                                class="button button-success"
                                wire:loading.attr="disabled"
                                wire:target="getDocument"
                                wire:click="getDocument({{ $stockTake->id }})"
                            >
                <span
                    class="pr-2"
                    wire:loading
                    wire:target="getDocument({{ $stockTake->id }})"
                >
                  <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                </span>
                                Print
                            </button>
                        @endif
                    </x-table.row>
                    <x-table.row class="text-center">
                        @if (!empty($stockTake->processed_at))
                            <div>
                                <button
                                    class="button button-success"
                                    wire:loading.attr="disabled"
                                    wire:target="getDocument"
                                    wire:click="getStockTakeDocument({{ $stockTake->id }})"
                                >
                  <span
                      class="pr-2"
                      wire:loading
                      wire:target="getStockTakeDocument({{ $stockTake->id }})"
                  >
                    <x-icons.refresh class="w-3 h-3 text-white animate-spin-slow" />
                  </span>
                                    Print
                                </button>
                            </div>
                        @else
                            <div>
                                <button
                                    class="button-danger"
                                    wire:click="delete('{{ $stockTake->id }}')"
                                >Delete
                                </button>
                            </div>
                        @endif
                    </x-table.row>
                </x-table.body>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.container>
    </div>
</div>
