<div>
  <button
    class="w-full button-success"
    wire:click="$toggle('modal')"
  ><span class="pl-2">Warranty</span>
  </button>

  <x-modal x-data="{ show: $wire.entangle('modal') }">

    <div class="pb-2">
      <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-300">New warranty</h3>
      <p class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $this->customer->name }}</p>
    </div>

    <div>
      <form wire:submit.prevent="save">
        <div class="py-3">
          <x-input.label for="reference">
            Reference
          </x-input.label>

          <div>
            <x-input.text
              id="reference"
              type="text"
              wire:model.defer="reference"
            />
          </div>
          @error('reference')
            <x-input.error>{{ $message }}</x-input.error>
          @enderror
        </div>
        <div class="py-3">
          <x-input.label for="date">
            Date
          </x-input.label>
          <div>
            <x-input.text
              id="date"
              type="date"
              wire:model.defer="date"
            />
          </div>
          @error('date')
            <x-input.error>{{ $message }}</x-input.error>
          @enderror
        </div>

        <div class="py-3">
          <x-input.label for="amount">
            Amount
          </x-input.label>
          <div>
            <x-input.text
              id="amount"
              type="number"
              wire:model.defer="amount"
              step="0.01"
              inputmode="numeric"
              pattern="[0-9.]+"
            />
          </div>
          @error('amount')
            <x-input.error>{{ $message }}</x-input.error>
          @enderror
        </div>
        <div class="py-3">
          <button
            class="button-success"
            wire:loading.attr="disabled"
            wire:target="save"
          >
            <x-icons.busy target="save" />
            save
          </button>
        </div>
      </form>
    </div>
  </x-modal>
</div>
