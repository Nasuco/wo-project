@props([
    'id' => 'searchInput',
    'placeholder' => 'Cari...',
])

<div 
    {{ $attributes->merge(['class' => 'w-full md:w-64']) }}
    x-data
    x-on:keydown.window.prevent.cmd.k="document.getElementById('{{ $id }}').focus()"
    x-on:keydown.window.prevent.ctrl.k="document.getElementById('{{ $id }}').focus()"
>
    <flux:input 
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        icon="magnifying-glass" 
        kbd="⌘K" 
        {{ $attributes->except(['class']) }} 
    />
</div>