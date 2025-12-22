<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Pengguna') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Atur semua pengguna kamu') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 flex items-center justify-between">
            <div class="text-lg font-medium text-gray-900 dark:text-white">Daftar Pengguna</div>
            <flux:modal.trigger name="create-user">
                <button
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </button>
            </flux:modal.trigger>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider w-12">
                            <div class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-600 dark:checked:bg-indigo-500">
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                            Nama Pengguna
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-600 dark:checked:bg-indigo-500">
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 dark:bg-indigo-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-800 dark:text-indigo-300 font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-zinc-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:button.group>
                                <flux:modal.trigger name="show-user">
                                    <flux:button icon="eye" color="purple" wire:click="openShowModal({{ $user->id }})" title="Detail"></flux:button>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="edit-user">
                                    <flux:button icon="pencil-square" color="blue" wire:click="openEditModal({{ $user->id }})" title="Edit"></flux:button>
                                </flux:modal.trigger>

                                <flux:button icon="trash" color="red" wire:click="confirmDelete({{ $user->id }})" title="Delete"></flux:button>
                            </flux:button.group>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <flux:modal name="create-user" flyout variant="floating" class="md:w-lg" wire:key="create-modal-{{ $modalKey }}">
                <form wire:submit.prevent="create" class="space-y-6">
                    <div class="p-6">
                        <flux:heading size="lg">Tambah Pengguna Baru</flux:heading>
                        <flux:subheading>Isi data pengguna baru.</flux:subheading>

                        <div class="space-y-4 mt-4">
                            <flux:input wire:model="form.name" label="Nama Pengguna" required />
                            <flux:input wire:model="form.email" label="Email" type="email" required />
                            <flux:input wire:model="form.password" label="Kata Sandi" type="password" required />
                            <flux:input wire:model="form.confirm_password" label="Konfirmasi Kata Sandi" type="password" required />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-700 px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <flux:modal.close>
                                <flux:button type="button" variant="filled">Batal</flux:button>
                            </flux:modal.close>

                            <flux:button type="submit" variant="primary">
                                Buat Pengguna
                            </flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>

            <flux:modal name="edit-user" flyout variant="floating" class="md:w-lg" wire:key="edit-modal-{{ $modalKey }}">
                <form id="edit-user-form" wire:submit.prevent="update" class="space-y-6">
                    <div class="p-6">
                        <flux:heading size="lg">Edit Pengguna</flux:heading>
                        <flux:subheading>Ubah data pengguna.</flux:subheading>

                        <div class="space-y-4 mt-4">
                            <flux:input wire:model="form.name" label="Nama Pengguna" />
                            <flux:input wire:model="form.email" label="Email" type="email" />
                            <flux:input wire:model="form.password" label="Kata Sandi (Opsional)" type="password" />
                            <flux:input wire:model="form.confirm_password" label="Konfirmasi Kata Sandi" type="password" />
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

            <flux:modal name="show-user" flyout variant="floating" class="md:w-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <flux:heading size="lg">Detail Pengguna</flux:heading>
                        <flux:subheading>Informasi lengkap pengguna.</flux:subheading>
                    </div>

                    @if($showUser)
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-16 w-16 bg-indigo-100 dark:bg-indigo-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-800 dark:text-indigo-300 font-bold text-xl">
                                        {{ strtoupper(substr($showUser->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $showUser->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-zinc-400">{{ $showUser->email }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 space-y-3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Email</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-zinc-200">{{ $showUser->email }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-zinc-700 pt-3">
                                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Dibuat</p>
                                    <p class="text-sm text-gray-900 dark:text-zinc-200">{{ $showUser->created_at->translatedFormat('d F Y H:i') }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase">Terakhir Diperbarui</p>
                                    <p class="text-sm text-gray-900 dark:text-zinc-200">{{ $showUser->updated_at->translatedFormat('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="animate-pulse space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="rounded-full bg-gray-200 dark:bg-zinc-700 h-16 w-16"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded w-1/2"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div slot="action" class="border-t border-gray-200 dark:border-zinc-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <flux:modal.close>
                                <flux:button variant="filled">Tutup</flux:button>
                            </flux:modal.close>
                            
                            @if($showUser)
                                <flux:modal.close>
                                    <flux:modal.trigger name="edit-user">
                                        <flux:button 
                                            variant="primary" 
                                            wire:click="openEditModal({{ $showUser->id }})"
                                            onclick="setTimeout(() => { window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: 'edit-user' } })) }, 100)">
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