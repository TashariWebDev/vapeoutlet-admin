<div
    class="relative z-10"
    role="dialog"
    aria-labelledby="modal-title"
    aria-modal="true"
>
    <!--
      Background backdrop, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="overflow-y-auto fixed inset-0 z-10">
        <div class="flex justify-center items-end p-4 min-h-full text-center sm:items-center sm:p-0">
            <!--
              Modal panel, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div
                class="overflow-hidden relative text-left bg-white rounded-lg shadow-xl transition-all transform sm:my-8 sm:w-full sm:max-w-lg">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <form
                        id="brandForm"
                        wire:submit.prevent="addBrand"
                        x-data=""
                    >
                        <div class="py-2">
                            <x-input
                                type="text"
                                wire:model.defer="brandName"
                                label="name"
                                required
                            />
                        </div>
                        <div class="py-2">
                            <x-input
                                type="file"
                                wire:model.defer="brandLogo"
                                label="logo"
                                required
                            />
                        </div>
                        <div class="py-2">
                            <button class="button-success">
                                <x-icons.busy target="save" />
                                save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="py-3 px-4 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                    <button
                        class="inline-flex justify-center py-2 px-4 mt-3 w-full text-base font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                        type="button"
                        x-on:click="show = !show"
                    >Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div --}}
{{--    class="relative z-50" --}}
{{--    role="dialog" --}}
{{--    aria-labelledby="modal-title" --}}
{{--    aria-modal="true" --}}
{{--    x-data="{ show: $wire.entangle('showBrandsForm') }" --}}
{{--    x-show="show" --}}
{{--    x-transition:enter="ease-out duration-300" --}}
{{--    x-transition:enter-start="opacity-0" --}}
{{--    x-transition:enter-end="opacity-100" --}}
{{--    x-transition:leave="ease-in duration-200" --}}
{{--    x-transition:leave-start="opacity-100" --}}
{{--    x-transition:leave-end="opacity-0" --}}
{{-- > --}}

{{--    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div> --}}

{{--    <div class="overflow-y-auto fixed inset-0 z-10"> --}}
{{--        <div --}}
{{--            class="flex justify-center items-end p-4 min-h-full text-center sm:items-center sm:p-0" --}}
{{--            x-show="show" --}}
{{--            x-transition:enter="ease-out duration-300" --}}
{{--            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" --}}
{{--            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" --}}
{{--            x-transition:leave="ease-in duration-200" --}}
{{--            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" --}}
{{--            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" --}}
{{--        > --}}

{{--            <div> --}}
{{--                <div --}}
{{--                    class="overflow-hidden relative px-4 pt-5 pb-4 text-left bg-white rounded-lg shadow-xl transition-all transform sm:p-6 sm:my-8 sm:w-full sm:max-w-lg"> --}}
{{--                    <div> --}}
{{--                        <div> --}}
<form
    id="brandForm"
    wire:submit.prevent="addBrand"
    x-data=""
>
    <div class="py-2">
        <x-input
            type="text"
            wire:model.defer="brandName"
            label="name"
            required
        />
    </div>
    <div class="py-2">
        <x-input
            type="file"
            wire:model.defer="brandLogo"
            label="logo"
            required
        />
    </div>
    <div class="py-2">
        <button class="button-success">
            <x-icons.busy target="save" />
            save
        </button>
    </div>
</form>
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="py-4 w-full bg-slate-500"> --}}
{{--                        <button --}}
{{--                            class="link" --}}
{{--                            x-on:click="show =  !show" --}}
{{--                        >cancel --}}
{{--                        </button> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--    </div> --}}
{{-- </div> --}}

{{-- <x-modal --}}
{{--    title="Manage brands" --}}
{{--    wire:model.defer="showBrandsForm" --}}
{{--    wire:key --}}
{{-- > --}}
{{--    <div> --}}
{{--        <form --}}
{{--            id="brandForm" --}}
{{--            wire:submit.prevent="addBrand" --}}
{{--            x-data="" --}}
{{--        > --}}
{{--            <div class="py-2"> --}}
{{--                <x-input --}}
{{--                    type="text" --}}
{{--                    wire:model.defer="brandName" --}}
{{--                    label="name" --}}
{{--                    required --}}
{{--                /> --}}
{{--            </div> --}}
{{--            <div class="py-2"> --}}
{{--                <x-input --}}
{{--                    type="file" --}}
{{--                    wire:model.defer="brandLogo" --}}
{{--                    label="logo" --}}
{{--                    required --}}
{{--                /> --}}
{{--            </div> --}}
{{--            <div class="py-2"> --}}
{{--                <button --}}
{{--                    class="button-success" --}}
{{--                    x-on:click="document.getElementById('brandForm').reset()" --}}
{{--                > --}}
{{--                    <x-icons.save class="mr-2 w-5 h-5" /> --}}
{{--                    save --}}
{{--                </button> --}}
{{--            </div> --}}
{{--        </form> --}}
{{--    </div> --}}
{{-- </x-modal> --}}
