<div class="rounded-md px-2 py-6">
    @php
        function check_file_exist($url){
            $handle = @fopen($url, 'r');
            if(!$handle){
                return false;
            }else{
                return true;
            }
        }
    @endphp
    <div class="w-full text-center flex justify-center">
        <x-inputs.search wire:model="searchTerm"/>
    </div>


    <div class="py-2">
        {{ $orders->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-6">
            <x-table.heading>Order #</x-table.heading>
            <x-table.heading>customer</x-table.heading>
            <x-table.heading class="text-center">status</x-table.heading>
            <x-table.heading class="text-center">delivery</x-table.heading>
            <x-table.heading class="text-right">dispatch</x-table.heading>
            <x-table.heading class="text-right">delivery note</x-table.heading>
        </x-table.header>
        @forelse($orders as $order)
            <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
                <x-table.row class="text-center lg:text-left">
                    <p>{{ $order->number}}</p>
                </x-table.row>
                <x-table.row class="text-center lg:text-left">
                    <p>{{$order->customer->name}}</p>
                </x-table.row>
                <x-table.row>
                    <div class="w-full flex justify-center items-center">
                        @if($order->status == 'received')
                            <x-icons.shopping-bag class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'processed')
                            <x-icons.clipboard class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'packed')
                            <x-icons.products class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'shipped')
                            <x-icons.truck class="w-5 h-5 text-green-600"/>
                        @endif

                        @if($order->status == 'completed')
                            <x-icons.tick class="w-5 h-5 text-green-600"/>
                        @endif
                    </div>
                </x-table.row>
                <x-table.row class="text-center">
                    <p>
                        <span class="font-bold lg:hidden">Delivery:</span> {{ $order->delivery->type }}</p>

                </x-table.row>
                <x-table.row class="p-2 text-right hidden lg:block">
                    <button class="button-success"
                            x-on:click="@this.call('pushToComplete',{{$order->id}})"
                    >Ship
                    </button>
                </x-table.row>
                <x-table.row class="text-center lg:text-right p-2">
                    @php
                        $document = config('app.admin_url')."/storage/delivery-note/{$order->number}.pdf";
                        $documentExists = check_file_exist($document)
                    @endphp
                    @if($documentExists)
                        <a href="{{$document}}" class="link">
                            &darr; print
                        </a>
                    @else
                        <button class="link" wire:click="getDocument({{$order->id}})">
                            request
                        </button>
                    @endif
                </x-table.row>
            </x-table.body>
        @empty
            <x-table.empty></x-table.empty>
        @endforelse
    </x-table.container>

</div>
