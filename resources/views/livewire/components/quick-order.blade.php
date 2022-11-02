<div>
    <div class="pr-4">
        <button
            class="button-success"
            wire:click="$toggle('searchModal')"
        >New order
        </button>
    </div>

    <x-modal wire:model.defer="searchModal"
             title="Select a customer"
    >
        <div class="h-72 w-full">
            <div>
                <label
                    for="search"
                    class="text-xs text-slate-400"
                >
                    Customer search
                </label>
                <div>
                    <input
                        autofocus
                        autocomplete="off"
                        class="w-full rounded-md"
                        wire:model="searchQuery"
                        id="search"
                        type="text"
                    />
                </div>
            </div>

            @if($searchQuery)
                <div class="h-48 w-full mt-1 overflow-y-scroll">
                    <ul>
                        @foreach($customers as $customer)
                            <li>
                                <button
                                    wire:click="createOrder({{$customer->id}})"
                                    class="w-full whitespace-nowrap text-left button-secondary mb-1"
                                >{{$customer->name}} {{$customer?->company}}</button>
                            </li>
                        @endforeach
                        <li>{{ $customers->links() }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </x-modal>
</div>
