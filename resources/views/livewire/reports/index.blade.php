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


    <div>
        <button x-on:click="@this.set('showStockTakeModal',true)" class="button-success">Create stock take</button>

        <div class="py-4">
            <a href="{{ route('stock-takes') }}" class="link">Stock Takes</a>
        </div>

        <x-modal title="Create a stock take" wire:model.defer="showStockTakeModal">
            <form wire:submit.prevent="createStockTake">
                <x-select wire:model.defer="brand">
                    @foreach($this->brands as $brand)
                        <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                    @endforeach
                </x-select>
                <div class="mt-2">
                    <button class="button-success">Create</button>
                </div>
            </form>
        </x-modal>
    </div>

    <div class="py-6">
        @php
            $debtors = config('app.admin_url')."/storage/documents/debtors-list.pdf";

            $documentExists = check_file_exist($debtors)
        @endphp

        <button class="button-success" wire:click="getDebtorListDocument">
            DEBTOR LIST
        </button>

        <div class="py-4">
            @if($documentExists)
                <a href="{{$debtors}}" class="link" wire:loading.class="hidden">
                    &darr; print
                </a>
            @endif
        </div>
    </div>
</div>
