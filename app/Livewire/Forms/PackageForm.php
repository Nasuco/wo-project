<?php

namespace App\Livewire\Forms;

use App\Models\Packages;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PackageForm extends Form
{
    public ?int $packageId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|numeric|min:0')]
    public int $price = 0;

    #[Validate('required|integer|min:1')]
    public int $duration_days = 1;

    #[Validate('required|integer|min:1')]
    public int $max_guests = 1;

    #[Validate('required|integer|min:0')]
    public int $max_gallery = 0;

    #[Validate('boolean')]
    public bool $custom_domain = false;

    #[Validate('boolean')]
    public bool $is_active = true;

    public function messages()
    {
        return [
            'name.required' => 'Nama paket wajib diisi.',
            'name.max' => 'Nama paket maksimal 255 karakter.',
            'price.required' => 'Harga paket wajib diisi.',
            'price.numeric' => 'Harga paket harus berupa angka.',
            'duration_days.required' => 'Durasi paket wajib diisi.',
            'duration_days.integer' => 'Durasi paket harus berupa angka bulat.',
            'max_guests.required' => 'Maksimal tamu wajib diisi.',
            'max_guests.integer' => 'Maksimal tamu harus berupa angka bulat.',
            'max_gallery.required' => 'Maksimal galeri wajib diisi.',
            'max_gallery.integer' => 'Maksimal galeri harus berupa angka bulat.',
        ];
    }

    public function setPackage(Packages $package)
    {
        $this->packageId = $package->id;
        $this->name = $package->name;
        $this->price = $package->price;
        $this->duration_days = $package->duration_days;
        $this->max_guests = $package->max_guests;
        $this->max_gallery = $package->max_gallery;
        
        $this->custom_domain = (bool) $package->custom_domain;
        $this->is_active = (bool) $package->is_active;
    }
}