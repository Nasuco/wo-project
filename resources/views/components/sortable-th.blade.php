@props(['name', 'sortCol', 'sortDir'])

<th scope="col" 
    wire:click="sortBy('{{ $name }}')" 
    {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors group select-none']) }}
>
    <div class="flex items-center gap-1">
        {{ $slot }}

        <span class="ml-1 flex-none rounded text-gray-400 group-hover:visible group-focus:visible transition-opacity duration-200
            {{ $sortCol === $name ? 'visible text-indigo-600 dark:text-indigo-400' : 'invisible' }}">
            
            @if($sortCol === $name && $sortDir === 'asc')
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            @else
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            @endif
        </span>
    </div>
</th>