<div>
    <div class="relative z-50"
         role="dialog"
         aria-modal="true"
         x-data="{ show: @entangle('modal') }"
         x-cloak
         x-show="show"
    >
        <div class="fixed inset-0 bg-opacity-50 transition-opacity bg-slate-800"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
        ></div>
        
        <div class="overflow-y-auto fixed inset-0 z-10 p-4 sm:p-6 md:p-20">
            
            <div class="overflow-hidden mx-auto max-w-3xl bg-white rounded-xl divide-y ring-1 ring-black ring-opacity-5 shadow-2xl transition-all transform divide-slate-100 dark:bg-slate-950 dark:divide-slate-800"
                 x-on:click.outside="show = !show"
                 x-trap.noscroll="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="relative">
                    <svg class="absolute top-3.5 left-4 w-5 h-5 pointer-events-none text-slate-400"
                         viewBox="0 0 20 20"
                         fill="currentColor"
                         aria-hidden="true"
                    >
                        <path fill-rule="evenodd"
                              d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                              clip-rule="evenodd"
                        />
                    </svg>
                    <label for="searchQuery"
                           class="hidden"
                    ></label>
                    <input type="text"
                           class="pr-4 pl-11 w-full h-12 border-0 sm:text-sm focus:ring-0 text-slate-800 placeholder:text-slate-400 bg-slate-200 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-sky-500"
                           placeholder="Search..."
                           role="combobox"
                           aria-expanded="false"
                           aria-controls="options"
                           autofocus
                           id="searchQuery"
                           wire:model.debounce.500ms="searchQuery"
                    >
                </div>
                
                <div class="flex divide-x divide-slate-100 dark:divide-slate-800">
                    <!-- Preview Visible: "sm:h-96" -->
                    <div class="overflow-y-scroll flex-auto py-4 px-6 min-w-0 max-h-96 sm:h-96 scroll-y-4">
                        <div>
                            {{ $customers->links() }}
                        </div>
                        <ul class="-mx-2 text-sm text-slate-700"
                            id="recent"
                            role="listbox"
                        >
                            @foreach($customers as $customer)
                                
                                <li class="p-2 rounded-md cursor-default select-none group"
                                    id="recent-1"
                                    role="option"
                                    tabindex="-1"
                                >
                                    <button class="flex justify-between items-center py-2 w-full rounded-md hover:text-white group hover:bg-sky-400"
                                            wire:mouseover="selectedCustomer('{{$customer->id}}')"
                                            wire:click="createOrder('{{$customer->id}}')"
                                    >
                                        <div class="ml-3 font-semibold text-left dark:text-white truncate">{{ $customer->name }}</div>
                                        <!-- Not Active: "hidden" -->
                                        <svg class="flex-none ml-3 w-5 h-5 group-hover:text-white text-slate-400 dark:text-sky-100"
                                             viewBox="0 0 20 20"
                                             fill="currentColor"
                                             aria-hidden="true"
                                        >
                                            <path fill-rule="evenodd"
                                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                  clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Active item side-panel, show/hide based on active state -->
                    @if($selectedCustomer)
                        <div class="hidden overflow-y-auto flex-col flex-none w-1/2 h-96 divide-y divide-white sm:flex dark:divide-slate-950">
                            <div class="flex-none p-6 text-center">
                                <div class="flex justify-center items-center mx-auto w-16 h-16 rounded-full bg-slate-200">
                                    <x-icons.user class="w-10 h-10"/>
                                </div>
                                <h2 class="mt-3 font-semibold dark:text-white text-slate-900">{{ ucwords($selectedCustomer->name) }}</h2>
                            </div>
                            <div class="flex flex-col flex-auto justify-between p-6">
                                <dl class="grid grid-cols-1 gap-y-3 gap-x-6 text-sm text-slate-700">
                                    <dt class="col-end-1 font-semibold dark:text-white text-slate-900">Phone</dt>
                                    <dd class="dark:text-white">{{ ucwords($selectedCustomer->phone) }}</dd>
                                    <dt class="col-end-1 font-semibold dark:text-white text-slate-900">Email</dt>
                                    <dd class="truncate">
                                        <a href="mailto:{{$selectedCustomer->email}}"
                                           class="underline lowercase text-sky-600 dark:blue-300"
                                        >{{ $selectedCustomer->email }}</a>
                                    </dd>
                                    <dt class="col-end-1 font-semibold dark:text-white text-slate-900">Company</dt>
                                    <dd class="dark:text-white">{{ ucwords($selectedCustomer->company) }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif
                
                </div>
            </div>
        </div>
    </div>

</div>
