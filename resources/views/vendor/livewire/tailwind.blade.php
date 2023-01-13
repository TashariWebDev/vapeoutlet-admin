<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))

        <nav
            class="flex justify-between items-center"
            role="navigation"
            aria-label="Pagination Navigation"
        >
            <div class="flex flex-1 justify-between sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border cursor-default select-none text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600"
                        >
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button
                            class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:border-blue-300 focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:text-slate-500 focus:shadow-outline-blue active:bg-slate-100 active:text-slate-700"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                        >
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button
                            class="inline-flex relative items-center py-2 px-4 ml-3 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:border-blue-300 focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:text-slate-500 focus:shadow-outline-blue active:bg-slate-100 active:text-slate-700"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                        >
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span
                            class="inline-flex relative items-center py-2 px-4 ml-3 text-sm font-medium leading-5 bg-white rounded-md border cursor-default select-none text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600"
                        >
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:justify-between sm:items-center">
                <div>
                    <p class="text-sm leading-5 text-slate-700 dark:text-slate-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>

                <div>
                    <span class="inline-flex relative z-0 rounded-md shadow-sm">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span
                                    aria-disabled="true"
                                    aria-label="{{ __('pagination.previous') }}"
                                >
                                    <span
                                        class="inline-flex relative items-center py-2 px-2 text-sm font-medium leading-5 bg-white rounded-l-md border cursor-default text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600"
                                        aria-hidden="true"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                </span>
                            @else
                                <button
                                    class="inline-flex relative items-center py-2 px-2 text-sm font-medium leading-5 bg-white rounded-l-md border transition duration-150 ease-in-out focus:z-10 focus:border-blue-300 focus:outline-none text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600 hover:text-slate-400 focus:shadow-outline-blue active:bg-slate-100 active:text-slate-500"
                                    aria-label="{{ __('pagination.previous') }}"
                                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="prev"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span
                                        class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium leading-5 bg-white border cursor-default select-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:border-slate-600"
                                    >{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span
                                        wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}"
                                    >
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium leading-5 bg-white border cursor-default select-none text-sky-600 border-slate-300 dark:text-sky-500 dark:bg-slate-800 dark:border-slate-600"
                                                >{{ $page }}</span>
                                            </span>
                                        @else
                                            <button
                                                class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium leading-5 bg-white border transition duration-150 ease-in-out focus:z-10 focus:border-blue-300 focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:text-slate-500 focus:shadow-outline-blue active:bg-slate-100 active:text-slate-700"
                                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            >
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button
                                    class="inline-flex relative items-center py-2 px-2 -ml-px text-sm font-medium leading-5 bg-white rounded-r-md border transition duration-150 ease-in-out focus:z-10 focus:border-blue-300 focus:outline-none text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600 hover:text-slate-400 focus:shadow-outline-blue active:bg-slate-100 active:text-slate-500"
                                    aria-label="{{ __('pagination.next') }}"
                                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="next"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            @else
                                <span
                                    aria-disabled="true"
                                    aria-label="{{ __('pagination.next') }}"
                                >
                                    <span
                                        class="inline-flex relative items-center py-2 px-2 -ml-px text-sm font-medium leading-5 bg-white rounded-r-md border cursor-default text-slate-500 border-slate-300 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600"
                                        aria-hidden="true"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
