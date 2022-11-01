<div x-data="{}">

    <div>
        <div class="grid grid-col-1 md:grid-cols-4 gap-3 px-2 py-1 border-b pb-4 bg-white rounded-md">
            <div class="order-last md:order-first md:col-span-2">
                <div class="pb-3">
                    <button class="button-danger w-full"
                            disabled
                    >Processed by {{$this->credit->created_by}} on {{ $this->credit->processed_at }}
                    </button>
                </div>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl underline underline-offset-4 pl-4">
                    R {{ number_format($this->credit->getTotal(),2) }}
                </h1>
                <h2>
                    <span class="text-xs">vat</span> {{ number_format(vat($this->credit->getTotal()),2) }}
                </h2>
            </div>
            <div class="text-right">
                <h1 class="font-bold text-4xl">{{ $this->credit->number }}</h1>
                <a class="text-right font-bold underline underline-offset-2 text-green-600 hover:text-yellow-500"
                   href="{{ route('suppliers/show',$this->credit->supplier->id) }}"
                >
                    {{ $this->credit->supplier->name }}
                </a>
                <h2>{{ $this->credit->created_at->format('Y-M-d') }}</h2>
            </div>
        </div>

        <div class="py-2 grid grid-cols-1 gap-y-2">
            @foreach($this->credit->items as $item)
                <div>
                    <div class="w-full bg-white grid grid-cols-2 md:grid-cols-5 gap-4 rounded-md py-2">
                        <div class="col-span-2 px-2 py-4">
                            <h4 class="font-bold">
                                {{ $item->product->brand }} {{ $item->product->name }}
                            </h4>
                            <div class="flex flex-wrap space-x-1 divide-x items-center">
                                @foreach($item->product->features as $feature)
                                    <p class="text-xs text-slate-600 px-0.5"
                                    > {{ $feature->name }}</p>
                                @endforeach
                            </div>
                            <p class="text-xs text-slate-400">{{ $item->product->sku }}</p>
                        </div>
                        <div class="px-2 py-6">
                            <p class="font-bold">
                                {{number_format($item->cost,2)}}
                            </p>
                        </div>
                        <div class="px-2 py-6">
                            <p class="font-bold">
                                {{$item->qty}}
                            </p>
                        </div>
                        <div class="px-4 py-6">
                            <div>
                                <p class="font-bold">
                                    {{ number_format($item->line_total,2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
