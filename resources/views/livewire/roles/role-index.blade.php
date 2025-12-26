<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Atur semua role kamu') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(count($selected) === 0)
        <div class="flex justify-end mb-4">
            <flux:button wire:click="export" icon="arrow-down-tray">
                Export Excel
            </flux:button>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 flex flex-col md:flex-row items-center justify-between gap-4">
            
            @if(count($selected) > 0)
                <x-bulk-action-bar :count="count($selected)" exportAction="exportBulk" />
            @else
                <div class="text-lg font-medium text-gray-900 dark:text-white w-full md:w-auto">
                    Daftar Role
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    
                    <x-search-input wire:model.live="search" />

                    <flux:modal.trigger name="create-role">
                        <button
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah
                        </button>
                    </flux:modal.trigger>
                </div>
            @endif

        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left w-12">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="selectAll"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-600 dark:checked:bg-indigo-500 cursor-pointer transition-colors"
                                >
                            </div>
                        </th>

                        <x-sortable-th name="name" :sort-col="$sortCol" :sort-dir="$sortDir">
                            Nama Role
                        </x-sortable-th>
                        
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                            Permission
                        </th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($roles as $role)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    value="{{ $role->id }}" 
                                    wire:model.live="selected"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-600 dark:checked:bg-indigo-500 cursor-pointer"
                                >
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $role->name }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2" title="{{ $role->permissions->pluck('name')->join(', ') }}">
                                {{-- Menampilkan badge atau text, dibatasi jika terlalu panjang --}}
                                @if($role->permissions->count() > 0)
                                    {{ $role->permissions->pluck('name')->take(5)->join(', ') }}
                                    @if($role->permissions->count() > 5)
                                        <span class="text-xs text-indigo-500 font-semibold">(+{{ $role->permissions->count() - 5 }})</span>
                                    @endif
                                @else
                                    <span class="italic text-gray-400">Tidak ada permission</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:button.group>
                                <flux:modal.trigger name="show-user">
                                    <flux:button icon="eye" size="sm" wire:click="openShowModal({{ $role->id }})" title="Detail" />
                                </flux:modal.trigger>

                                <flux:modal.trigger name="edit-user">
                                    <flux:button icon="pencil-square" size="sm" wire:click="openEditModal({{ $role->id }})" title="Edit" />
                                </flux:modal.trigger>

                                <flux:button icon="trash" size="sm" variant="danger" wire:click="confirmDelete({{ $role->id }})" title="Delete" />
                            </flux:button.group>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data role ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <x-pagination :paginator="$roles" />
            
        </div>
    </div>
</div>