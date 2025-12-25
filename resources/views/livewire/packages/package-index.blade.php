<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Paket') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Atur semua paket kamu') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(count($selected) === 0)
        <div class="flex justify-end mb-4">
            <flux:button 
                wire:click="export" 
                icon="arrow-down-tray" 
            >
                Export Excel
            </flux:button>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 flex items-center justify-between">
            @if(count($selected) > 0)
                <x-bulk-action-bar :count="count($selected)" exportAction="exportBulk" />
            @else
                <div class="text-lg font-medium text-gray-900 dark:text-white w-full md:w-auto">
                    Daftar Paket
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">

                    <x-search-input wire:model.live="search" />

                    <flux:modal.trigger name="create-package">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
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
                            Nama Paket
                        </x-sortable-th>
                        <x-sortable-th name="price" :sort-col="$sortCol" :sort-dir="$sortDir">
                            Harga
                        </x-sortable-th>
                        <x-sortable-th name="duration_days" :sort-col="$sortCol" :sort-dir="$sortDir">
                            Durasi
                        </x-sortable-th>
                        <x-sortable-th name="is_active" :sort-col="$sortCol" :sort-dir="$sortDir">
                            Status
                        </x-sortable-th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @foreach($packages as $package)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    value="{{ $package->id }}" 
                                    wire:model.live="selected"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-600 dark:checked:bg-indigo-500 cursor-pointer"
                                >
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $package->name }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-zinc-200">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-zinc-200">
                                {{ $package->duration_days }} hari
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->is_active ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400' }}">
                                {{ $package->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:button.group>
                                <flux:modal.trigger name="show-package">
                                    <flux:button icon="eye" color="purple" wire:click="openShowModal({{ $package->id }})" title="Detail"></flux:button>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="edit-package">
                                    <flux:button icon="pencil-square" color="blue" wire:click="openEditModal({{ $package->id }})" title="Edit"></flux:button>
                                </flux:modal.trigger>

                                <flux:button icon="trash" color="red" wire:click="confirmDelete({{ $package->id }})" title="Delete"></flux:button>
                            </flux:button.group>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <x-pagination :paginator="$packages" />

            <flux:modal name="create-package" flyout variant="floating" class="md:w-lg" wire:key="create-modal-{{ $modalKey }}">
                <form wire:submit.prevent="create" class="space-y-6">
                    <div class="p-6">
                        <flux:heading size="lg">Tambah Paket Baru</flux:heading>
                        <flux:subheading>Isi data paket baru.</flux:subheading>
                        
                        <div class="space-y-4 mt-4">
                            <flux:input wire:model="form.name" label="Nama Paket" required />
                            <flux:input wire:model="form.price" label="Harga" type="number" min="0" required />
                            <flux:input wire:model="form.duration_days" label="Durasi (hari)" type="number" min="1" required />
                            <flux:input wire:model="form.max_guests" label="Maks. Tamu" type="number" min="1" required />
                            <flux:input wire:model="form.max_gallery" label="Maks. Galeri" type="number" min="1" required />
                            
                            <flux:checkbox wire:model="form.custom_domain" label="Custom Domain" />
                            <flux:checkbox wire:model="form.is_active" label="Aktif" />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-700 px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <flux:modal.close>
                                <flux:button type="button" variant="filled">Batal</flux:button>
                            </flux:modal.close>

                            <flux:button type="submit" variant="primary">
                                Buat Paket
                            </flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>

            <flux:modal name="edit-package" flyout variant="floating" class="md:w-lg" wire:key="edit-modal-{{ $modalKey }}">
                <form id="edit-package-form" wire:submit.prevent="update" class="space-y-6">
                    <div class="p-6">
                        <flux:heading size="lg">Edit Paket</flux:heading>
                        <flux:subheading>Ubah data paket.</flux:subheading>

                        <div class="space-y-4 mt-4">
                            <flux:input wire:model="form.name" label="Nama Paket" />
                            <flux:input wire:model="form.price" label="Harga" type="number" min="0" />
                            <flux:input wire:model="form.duration_days" label="Durasi (hari)" type="number" min="1" />
                            <flux:input wire:model="form.max_guests" label="Maks. Tamu" type="number" min="1" />
                            <flux:input wire:model="form.max_gallery" label="Maks. Galeri" type="number" min="1" />
                            
                            <flux:checkbox wire:model="form.custom_domain" label="Custom Domain" />
                            <flux:checkbox wire:model="form.is_active" label="Aktif" />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-700 px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <flux:modal.close>
                                <flux:button type="button" variant="filled">Batal</flux:button>
                            </flux:modal.close>

                            <flux:button type="submit" variant="primary">
                                Simpan
                            </flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>

            <flux:modal name="show-package" flyout variant="floating" class="md:w-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <flux:heading size="lg">Detail Paket</flux:heading>
                        <flux:subheading>Informasi lengkap paket.</flux:subheading>
                    </div>

                    @if($showPackage)
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 space-y-3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Nama Paket</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showPackage->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Status</p>
                                        <p class="text-sm font-medium {{ $showPackage->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $showPackage->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Harga</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ number_format($showPackage->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Durasi</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showPackage->duration_days }} Hari</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Maks. Tamu</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showPackage->max_guests }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Maks. Galeri</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showPackage->max_gallery }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Custom Domain</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showPackage->custom_domain ? 'Ya' : 'Tidak' }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-zinc-700 pt-3">
                                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Dibuat</p>
                                    <p class="text-sm text-gray-900 dark:text-zinc-200">{{ $showPackage->created_at }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Terakhir Diperbarui</p>
                                    <p class="text-sm text-gray-900 dark:text-zinc-200">{{ $showPackage->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-zinc-400">Loading data paket...</p>
                        </div>
                    @endif
                </div>

                <div slot="action" class="border-t border-gray-200 dark:border-zinc-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <flux:modal.close>
                                <flux:button variant="filled">Tutup</flux:button>
                            </flux:modal.close>
                            
                            @if($showPackage)
                                <flux:modal.close>
                                    <flux:modal.trigger name="edit-package">
                                        <flux:button 
                                            variant="primary" 
                                            wire:click="openEditModal({{ $showPackage->id }})"
                                            onclick="setTimeout(() => { window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: 'edit-package' } })) }, 100)">
                                            Edit
                                        </flux:button>
                                    </flux:modal.trigger>
                                </flux:modal.close>
                            @endif
                        </div>
                    </div>
                </div>
            </flux:modal>
        </div>
    </div>
</div>