<?php

namespace App\Livewire\Packages;

use App\Domain\Packages\DTOs\CreatePackageDTO;
use App\Domain\Packages\DTOs\UpdatePackageDTO;
use App\Livewire\Forms\PackageForm;
use App\Models\Packages;
use App\Services\Packages\PackageService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use function Flasher\Prime\flash;

class PackageIndex extends Component
{
    use WithPagination;
    public $search = '';
    public PackageForm $form;
    public $modalKey = 0;
    public $showPackage;
    public $deletePackageId;

    protected PackageService $packageService;

    public function boot(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        //
    }

    public function render()
    {
        $packages = $this->packageService->getPaginatedPackages(10, $this->search); 

        return view('livewire.packages.package-index', [
            'packages' => $packages
        ]);
    }

    public function create()
    {
        $this->form->validate();

        $dto = new CreatePackageDTO(
            $this->form->name,
            $this->form->price,
            $this->form->duration_days,
            $this->form->max_guests,
            $this->form->max_gallery,
            $this->form->custom_domain,
            $this->form->is_active,
        );

        $this->packageService->createPackage($dto);
        $this->resetPage();

        $this->afterAction('Paket berhasil dibuat.');
    }
    
    public function openEditModal($id)
    {
        $package = $this->packageService->getPackageById($id);
        $this->form->setPackage($package);
    }

    public function update()
    {
        $this->form->validate();

        $dto = new UpdatePackageDTO(
            $this->form->name,
            $this->form->price,
            $this->form->duration_days,
            $this->form->max_guests,
            $this->form->max_gallery,
            $this->form->custom_domain,
            $this->form->is_active,
        );

        $this->packageService->updatePackage($this->form->packageId, $dto);
        $this->afterAction('Paket berhasil diperbarui.');
    }

    public function openShowModal($id)
    {
        $this->modalKey++;
        $this->showPackage = $this->packageService->getPackageById($id);
    }

    public function confirmDelete(?int $id = null): void
    {
        if (!$id) return;
        
        $this->deletePackageId = $id;
        sweetalert()
            ->showDenyButton()
            ->confirmButtonText('Ya, hapus')
            ->denyButtonText('Batal')
            ->warning('Apakah benar ingin menghapus paket ini?');
    }

    #[On('sweetalert:confirmed')]
    public function onDeleteConfirmed(): void
    {
        if ($this->deletePackageId) {
            $this->packageService->deletePackage($this->deletePackageId);
            $this->deletePackageId = null;
            $this->refreshPackages();
            $this->afterAction('Paket berhasil dihapus.');
        }
    }

    private function refreshPackages()
    {
        $this->packages = $this->packageService->getAllPackages();
    }

    private function afterAction($message)
    {
        $this->refreshPackages();
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