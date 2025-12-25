@props([
    'count' => 0,
    'resetAction' => 'resetSelection',
    'deleteAction' => 'confirmBulkDelete',
    'exportAction' => 'export'
])

<div {{ $attributes->merge(['class' => 'w-full flex items-center justify-between bg-indigo-50 dark:bg-indigo-900/20 px-4 py-2 rounded-md border border-indigo-100 dark:border-indigo-800 animate-in fade-in zoom-in duration-200']) }}>
    
    <div class="flex items-center gap-2">
        <flux:dropdown>
                <flux:button square variant="ghost" size="sm" icon="ellipsis-horizontal" />
            <flux:menu>
                <flux:menu.item 
                    wire:click="{{ $exportAction }}" 
                    icon="arrow-down-tray" 
                    wire:target="{{ $exportAction }}"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="{{ $exportAction }}">
                        Export Excel
                    </span>

                    <span wire:loading wire:target="{{ $exportAction }}">
                        Sedang Export...
                    </span>
                </flux:menu.item>

                <flux:menu.separator />

                <flux:menu.item 
                    wire:click="{{ $deleteAction }}" 
                    icon="trash" 
                    variant="danger"
                    wire:target="{{ $deleteAction }}"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="{{ $deleteAction }}">
                        Hapus Terpilih
                    </span>
                    <span wire:loading wire:target="{{ $deleteAction }}">
                        Menghapus...
                    </span>
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
        <flux:button 
            wire:click="{{ $resetAction }}" 
            variant="ghost" 
            size="sm"
            class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200"
        >
            Batal
        </flux:button>
    </div>

    <div class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
        <span class="font-bold">{{ $count }}</span> data dipilih
    </div>
</div>