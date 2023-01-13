<div>
    <button
        class="w-full button-success"
        wire:click="$toggle('slide')"
    >
        New transfer
    </button>

    <x-slide-over x-data="{ show: $wire.entangle('slide') }">
        <form wire:submit.prevent="save">
            <div class="relative">
                <div class="flex items-end py-2">
                    <div class="flex-1">
                        <x-input.label for="supplier">
                            Select an sales channel to transfer from
                        </x-input.label>
                        <x-input.select
                            id="dispatcher_id"
                            wire:model="dispatcher_id"
                        >
                            <option value="">Choose</option>
                            @foreach ($dispatchers as $dispatcher)
                                <option value="{{ $dispatcher->id }}">{{ $dispatcher->name }}</option>
                            @endforeach
                        </x-input.select>
                        @error('dispatcher_id')
                            <x-input.error>{{ $message }}</x-input.error>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="relative">
                <div class="flex items-end py-2">
                    <div class="flex-1">
                        <x-input.label for="receiver_id">
                            Select an sales channel to transfer to
                        </x-input.label>
                        <x-input.select
                            id="receiver_id"
                            wire:model="receiver_id"
                        >
                            <option value="">Choose</option>
                            @foreach ($receivers as $receiver)
                                <option value="{{ $receiver->id }}">{{ $receiver->name }}</option>
                            @endforeach
                        </x-input.select>
                        @error('receiver_id')
                            <x-input.error>{{ $message }}</x-input.error>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="py-2 mt-2">
                <button class="button-success">
                    save
                </button>
            </div>
        </form>
    </x-slide-over>
</div>
