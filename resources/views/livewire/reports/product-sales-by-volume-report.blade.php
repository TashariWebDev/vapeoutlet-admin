<div>
  <div>
    <button
      class="w-full button-success"
      wire:click.prevent="$toggle('showSalesByVolumeForm')"
    >
      Product sales by volume report
    </button>

    <div class="p-2">
      <p class="text-xs text-slate-500">Product sales by volume report between a specified date</p>
    </div>
  </div>

  <x-modal x-data="{ show: $wire.entangle('showSalesByVolumeForm') }">
    <form wire:submit.prevent="print">
      <div class="py-4">
        <x-input.text
          type="date"
          label="From date"
          wire:model.defer="fromDate"
        />
        @error('fromDate')
          <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="py-4">
        <x-input.text
          type="date"
          label="To date"
          wire:model.defer="toDate"
        />
        @error('toDate')
          <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="py-4">
        <x-input.select wire:model.defer="brand">
          <option value="">Choose</option>
          @foreach ($brands as $brand)
            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
          @endforeach
        </x-input.select>
        @error('brand')
          <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="py-2">
        <button class="button-success">
          <x-icons.busy target="print" />
          Get report
        </button>
      </div>
    </form>
  </x-modal>
</div>
