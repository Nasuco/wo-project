<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class PackagesExport implements FromCollection, WithHeadings, WithMapping
{
    private int $rowNumber = 0;
    public function __construct(protected Collection $packages) {}

    public function collection()
    {
        return $this->packages;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Paket',
            'Harga',
            'Durasi',
            'Maksimal Tamu',
            'Maksimal Galeri',
            'Custom Domain',
            'Status',
            'Tanggal Dibuat'
        ];
    }
    
    public function map($package): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $package->name,
            'Rp. ' . number_format($package->price, 0, ',', '.'),
            $package->duration_days . ' Hari',
            $package->max_guests,
            $package->max_gallery,
            $package->custom_domain ? 'Ya' : 'Tidak',
            $package->is_active ? 'Aktif' : 'Tidak Aktif',
            $package->created_at->format('d-m-Y'),
        ];
    }
}
