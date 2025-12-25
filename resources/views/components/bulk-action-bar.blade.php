@props([
    'count' => 0,
    'resetAction' => 'resetSelection',
    'deleteAction' => 'confirmBulkDelete'
])

<div {{ $attributes->merge(['class' => 'w-full flex items-center justify-between bg-indigo-50 dark:bg-indigo-900/20 px-4 py-2 rounded-md border border-indigo-100 dark:border-indigo-800 animate-in fade-in zoom-in duration-200']) }}>
    
    <div class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
        <span class="font-bold">{{ $count }}</span> data dipilih
    </div>
    
    <div class="flex items-center gap-3">
        <flux:button 
            wire:click="{{ $resetAction }}" 
            variant="ghost" 
            size="sm"
            class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200"
        >
            Batal
        </flux:button>
        <flux:button 
            wire:click="{{ $deleteAction }}" 
            variant="primary"
            color="red"
            size="sm" 
            icon="trash"
        >
            Hapus Terpilih
        </flux:button>
    </div>
</div>