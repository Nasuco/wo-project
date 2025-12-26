<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            "role.view",
            "role.create",
            "role.edit",
            "role.delete",
            "package.view",
            "package.create",
            "package.edit",
            "package.delete",
        ];

        foreach ($permission as $key => $value) {
            Permission::create(['name' => $value]);
        }
    }
}
