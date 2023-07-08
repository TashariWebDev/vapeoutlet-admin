<div>
    <x-modal
        x-data="{ show: $wire.entangle('modal') }"
        x-cloak
    >

        <div class="pb-2">
            <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">Select active sales channel</h3>
        </div>

        <div class="py-6">
            @foreach ($this->salesChannels as $channel)
                <div class="py-2">
                    <button
                        class="inline-flex items-center w-full button-success"
                        wire:click="setDefaultChannel('{{ $channel->id }}')"
                    >
                        @if ($channel->pivot->is_default)
                            <x-icons.tick class="mr-2 w-4 h-4 text-white" />
                        @endif
                        {{ $channel->name }}
                    </button>
                </div>
            @endforeach
        </div>
    </x-modal>
</div>
