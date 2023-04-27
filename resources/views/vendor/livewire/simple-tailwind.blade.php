<div>
    @if ($paginator->hasPages())
        <nav role="navigation"
             aria-label="Pagination Navigation"
             class="flex justify-between"
        >
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border cursor-default select-none text-slate-500 border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-900">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button dusk="previousPage"
                                wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                                wire:loading.attr="disabled"
                                class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:outline-none text-slate-700 border-slate-300 hover:text-slate-500 focus:border-sky-300 focus:shadow-outline-blue active:text-slate-700 active:bg-slate-100"
                        >
                                {!! __('pagination.previous') !!}
                        </button>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-900 hover:text-slate-500 focus:border-sky-300 focus:shadow-outline-blue active:text-slate-700 active:bg-slate-100"
                        >
                                {!! __('pagination.previous') !!}
                        </button>
                    @endif
                @endif
            </span>
            <span class="text-xs dark:text-white text-slate-800">Page {{$paginator->currentPage()}}</span>
            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button dusk="nextPage"
                                wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                                wire:loading.attr="disabled"
                                class="inline-flex relative items-center py-2 px-4 ml-3 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-900 hover:text-slate-500 focus:border-sky-300 focus:shadow-outline-blue active:text-slate-700 active:bg-slate-100"
                        >
                                {!! __('pagination.next') !!}
                        </button>
                    @else
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="inline-flex relative items-center py-2 px-4 ml-3 text-sm font-medium leading-5 bg-white rounded-md border transition duration-150 ease-in-out focus:outline-none text-slate-700 border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-900 hover:text-slate-500 focus:border-sky-300 focus:shadow-outline-blue active:text-slate-700 active:bg-slate-100"
                        >
                                {!! __('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 bg-white rounded-md border cursor-default select-none text-slate-500 border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-900">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
