<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RoleForm extends Form
{
    public ?int $roleId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public function rules($isEdit = false)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:roles,name' . ($isEdit ? ',' . $this->roleId : ''),
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama peran wajib diisi.',
            'name.max' => 'Nama peran maksimal 255 karakter.',
            'name.unique' => 'Nama peran sudah digunakan.',
        ];
    }

    public function setRole($role)
    {
        $this->roleId = $role->id;
        $this->name = $role->name;
    }
}