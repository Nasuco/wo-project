@props(['paginator'])

@if($paginator->hasPages())
<div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
        
        <div class="text-sm text-gray-600 dark:text-zinc-400">
            Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data
        </div>
        
        <nav class="flex items-center space-x-2">
            
            <button 
                wire:click="previousPage"
                wire:loading.attr="disabled"
                @if($paginator->onFirstPage()) disabled @endif
                class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                    {{ $paginator->onFirstPage() 
                        ? 'text-gray-400 dark:text-zinc-600 cursor-not-allowed' 
                        : 'text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800' 
                    }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Sebelumnya
            </button>

            <div class="hidden md:flex items-center space-x-1">
                @php
                    $elements = \Illuminate\Pagination\UrlWindow::make($paginator);
                @endphp

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 rounded-md text-sm font-medium text-gray-500 dark:text-zinc-500 cursor-default">
                            {{ $element }}
                        </span>
                    @endif
                    
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 rounded-md text-sm font-medium bg-indigo-600 text-white shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button 
                                    wire:click="gotoPage({{ $page }})"
                                    class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors duration-200">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <div class="md:hidden text-sm text-gray-600 dark:text-zinc-400">
                Hal {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </div>
            
            <button 
                wire:click="nextPage"
                wire:loading.attr="disabled"
                @if(!$paginator->hasMorePages()) disabled @endif
                class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                    {{ !$paginator->hasMorePages() 
                        ? 'text-gray-400 dark:text-zinc-600 cursor-not-allowed' 
                        : 'text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800' 
                    }}">
                Selanjutnya
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </nav>
    </div>
</div>
@endif