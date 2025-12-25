<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    private int $rowNumber = 0;
    public function __construct(protected Collection $users) {}

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Email',
            'Tanggal Bergabung',
        ];
    }

    public function map($user): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $user->name,
            $user->email,
            $user->created_at->format('d-m-Y'),
        ];
    }
}