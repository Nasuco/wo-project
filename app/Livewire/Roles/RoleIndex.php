<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use App\Services\Roles\RoleService;
use Livewire\Component;
use Livewire\WithPagination;

class RoleIndex extends Component
{
    use WithPagination;

    // Properti filter & sort
    public $search = '';
    public $sortCol = 'created_at';
    public $sortDir = 'desc';

    // Properti Selection
    public $selected = [];
    public $selectAll = false;
    
    // Properti Modal & Form (Disiapkan untuk next step)
    public RoleForm $form;
    public $modalKey = 0;
    
    // Services
    protected RoleService $roleService;

    public function boot(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    // Reset halaman ke 1 saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    // Logic Sorting
    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortCol = $column;
            $this->sortDir = 'asc';
        }
    }

    // Logic Select All
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Ambil ID dari halaman saat ini saja (sesuai best practice pagination)
            $this->selected = $this->roleService->paginateRoles(
                10, $this->search, $this->sortCol, $this->sortDir
            )->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function render()
    {
        $roles = $this->roleService->paginateRoles(
            10,
            $this->search,
            $this->sortCol,
            $this->sortDir
        );

        return view('livewire.roles.role-index', [
            'roles' => $roles
        ]);
    }
    
    // Placeholder method untuk modal (agar view tidak error saat diklik)
    public function openCreateModal() { $this->modalKey++; }
    public function openEditModal($id) { /* Logic edit nanti */ }
    public function confirmDelete($id) { /* Logic delete nanti */ }
    public function openShowModal($id) { /* Logic show nanti */ }
    public function export() { /* Logic export nanti */ }
}