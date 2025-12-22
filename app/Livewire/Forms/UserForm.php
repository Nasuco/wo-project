<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?int $userId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $confirm_password = '';

    public function rules($isEdit = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($isEdit ? ',' . $this->userId : ''),
        ];

        if (!$isEdit) {
            $rules['password'] = 'required|min:8';
            $rules['confirm_password'] = 'required|same:password';
        } else {
            $rules['password'] = 'nullable|min:8';
            $rules['confirm_password'] = 'nullable|same:password';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'confirm_password.same' => 'Konfirmasi kata sandi tidak cocok.',
        ];
    }

    public function setUser($user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }
}