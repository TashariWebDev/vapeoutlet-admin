<div>
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

    <div class="py-3">
        {{ $stockTakes->links() }}
    </div>

    <x-table.container>
        <x-table.header class="hidden lg:grid lg:grid-cols-6">
            <x-table.heading>ID</x-table.heading>
            <x-table.heading>DATE</x-table.heading>
            <x-table.heading>BRAND</x-table.heading>
            <x-table.heading>CREATED BY</x-table.heading>
            <x-table.heading>COUNT SHEET</x-table.heading>
            <x-table.heading class="text-center">PROCESSED</x-table.heading>
        </x-table.header>
        <x-table.body class="grid grid-cols-1 lg:grid-cols-6">
            @forelse($stockTakes as $stockTake)
                <x-table.row>
                    <a href="{{ route('stock-takes/show',$stockTake->id) }}"
                       class="link"
                    >{{$stockTake->id}}</a>
                </x-table.row>
                <x-table.row>
                    <p>{{$stockTake->created_at}}</p>
                </x-table.row>
                <x-table.row>
                    <p class="uppercase">{{$stockTake->brand}}</p>
                </x-table.row>
                <x-table.row>
                    <p>{{$stockTake->created_by}}</p>
                </x-table.row>
                <x-table.row>
                    @php
                        $document = config('app.admin_url')."/storage/stock-counts/{$stockTake->id}.pdf";
                        $stockTakeDocument = config('app.admin_url')."/storage/stock-takes/{$stockTake->id}.pdf";

                        $stockTakeDocumentExists = check_file_exist($stockTakeDocument);
                        $documentExists = check_file_exist($document)
                    @endphp
                    @if($documentExists)
                        <a href="{{$document}}"
                           class="link"
                        >
                            &darr; print
                        </a>
                    @else
                        <button class="link"
                                wire:click="getDocument({{ $stockTake->id }})"
                        >
                            request
                        </button>
                    @endif
                </x-table.row>
                <x-table.row class="text-center">
                    <div class="flex justify-center items-center">
                        @if($stockTake->processed_at)
                            @if($stockTakeDocumentExists)
                                <a href="{{$stockTakeDocument}}"
                                   class="link"
                                >
                                    &darr; print
                                </a>
                            @else
                                <button class="link"
                                        wire:click="getStockTakeDocument({{ $stockTake->id }})"
                                >
                                    request
                                </button>
                            @endif
                        @else
                            <x-icons.cross class="text-red-600 w-5 h-5"/>
                        @endif
                    </div>
                </x-table.row>
            @empty
                <x-table.empty></x-table.empty>
            @endforelse
        </x-table.body>
    </x-table.container>
</div>
