<?php

namespace App\Livewire\Users;

use App\Domain\Users\DTOs\CreateUserDTO;
use App\Domain\Users\DTOs\UpdateUserDTO;
use App\Exports\UsersExport;
use App\Livewire\Forms\UserForm;
use App\Services\Users\UserService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use function Flasher\Prime\flash;

class UserIndex extends Component
{
    use WithPagination;
    public $search = '';
    public UserForm $form;
    public $modalKey = 0;
    public $showUser;
    public $deleteUserId;
    public $sortCol = 'created_at';
    public $sortDir = 'desc';
    public $selected = [];
    public $selectAll = false;
    public bool $isBulkDeletion = false;

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    

    public function mount()
    {
        //
    }

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortCol = $column;
            $this->sortDir = 'asc';
        }
    }

    public function render()
    {
        $users = $this->userService->paginateUsers(
            10,
            $this->search,
            $this->sortCol,
            $this->sortDir
        );
        return view('livewire.users.user-index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $this->form->validate($this->form->rules(isEdit: false), $this->form->messages());

        $dto = new CreateUserDTO(
            $this->form->name,
            $this->form->email,
            $this->form->password
        );

        $this->userService->createUser($dto);
        
        $this->afterAction('Pengguna berhasil dibuat.');
    }

    public function openEditModal($id)
    {
        $user = $this->userService->getUserById($id);
        $this->form->setUser($user);

        $this->form->password = null;
        $this->form->confirm_password = null;
    }

    public function update()
    {
        $this->form->validate($this->form->rules(isEdit: true), $this->form->messages());

        $dto = new UpdateUserDTO(
            $this->form->name,
            $this->form->email,
            $this->form->password
        );

        $this->userService->updateUser($this->form->userId, $dto);
        $this->afterAction('Pengguna berhasil diubah.');
    }

    public function openShowModal($id)
    {
        $this->modalKey++;
        $this->showUser = $this->userService->getUserById($id);
    }

    public function confirmDelete(?int $id = null): void
    {
        if (!$id) return;
        
        $this->isBulkDeletion = false;
        $this->deleteUserId = $id;
        sweetalert()
            ->showDenyButton()
            ->confirmButtonText('Ya, hapus')
            ->denyButtonText('Batal')
            ->warning('Apakah benar ingin menghapus pengguna ini?');
    }

    public function confirmBulkDelete()
    {
        if (empty($this->selected)) {
            flash()->error('Tidak ada data yang dipilih.');
            return;
        }

        $this->isBulkDeletion = true;

        sweetalert()
            ->showDenyButton()
            ->confirmButtonText('Ya, hapus semua')
            ->denyButtonText('Batal')
            ->warning('Anda akan menghapus ' . count($this->selected) . ' data terpilih!');
    }

    #[On('sweetalert:confirmed')]
    public function onDeleteConfirmed(): void
    {
        if ($this->isBulkDeletion) {
            $this->userService->bulkDeleteUsers($this->selected);
            
            $this->resetSelection();
            $this->refreshUsers();
            
            flash()->success('Data terpilih berhasil dihapus.');
            
            $this->isBulkDeletion = false;
        }
        elseif ($this->deleteUserId) {
            $this->userService->deleteUser($this->deleteUserId);
            
            $this->deleteUserId = null;
            $this->refreshUsers();
            
            flash()->success('Pengguna berhasil dihapus.');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->userService
                ->paginateUsers(10, $this->search)
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedPage() { $this->resetSelection(); }
    public function updatedSearch() { $this->resetSelection(); }

    public function resetSelection()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;

        $this->userService->bulkDeleteUsers($this->selected);

        $this->resetSelection();
        $this->refreshUsers();
        
        flash()->success('Data terpilih berhasil dihapus.'); 
    }

    public function export()
    {
        $data = $this->userService->getUsersForExport(
            $this->selected, 
            $this->search, 
            $this->sortCol, 
            $this->sortDir
        );

        $fileName = 'users-' . date('Y-m-d-His') . '.xlsx';

        return Excel::download(new UsersExport($data), $fileName);
    }

    public function exportBulk()
    {
        return $this->export();
    }

    private function refreshUsers()
    {
        $this->users = $this->userService->getAllUsers();
    }

    private function afterAction($message)
    {
        $this->refreshUsers();
        $this->modalKey++;
        $this->form->reset();
        flash()->success($message);
    }
    
    public function resetCreateForm()
    {
        $this->form->reset();
    }
    
    public function openCreateModal()
    {
        $this->modalKey++;
        $this->form->reset();
    }
}