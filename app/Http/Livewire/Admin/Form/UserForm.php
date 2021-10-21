<?php

namespace App\Http\Livewire\Admin\Form;

use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserForm extends Component
{
    public $user;

    public $slug, $name, $phone_number, $address, $email, $role_id, $roles;
    public $password, $password_confirmation;
    public $edit;

    public $buttonText = 'Create';

    protected $rules = [
        'name' => 'required|max:80',
        'role_id' => 'required',
        'password' => 'required|confirmed',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable|numeric|digits_between:10,15',
        'address' => 'nullable|regex:^[#.0-9a-zA-Z\s,-]+$^'
    ];

    public function mount($model = null)
    {
        $this->edit = isset($model) ? true : false;

        if (isset($model)) {
            $this->user = $model;
            $this->email = $this->user->email;
            $this->name = $this->user->name;
            $this->phone_number = $this->user->phone_number;
            $this->address = $this->user->address;

            $this->role_id = $this->user->role->id;
            $this->buttonText = 'Update';
        }

        $this->roles = Role::all();
    }

    public function generatePassword()
    {
        // $this->password = substr(md5(microtime()),rand(0,26),8);
        $this->password = chr(rand() > 0.5 ? rand(65, 90) : rand(97, 122));
    }

    public function submit()
    {
        if ($this->edit) {
            $data = $this->validate([
                'name' => 'required|max:80',
                'role_id' => 'required',
                'password' => 'nullable|confirmed',
                'phone_number' => 'nullable|numeric|digits_between:10,15',
                'address' => 'nullable|regex:^[#.0-9a-zA-Z\s,-]+$^'
            ]);
        }
        if (!$this->edit) {
            $data = $this->validate($this->rules);
        }

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $this->user->password;
        }

        if ($this->edit) {
            $this->user->update($data);
            session()->flash('success', 'User successfully updated.');
        } else {
            $this->user = User::create($data);
            session()->flash('success', 'User successfully created.');
        }
        return redirect()->route('admin.users.edit', $this->user->id);
    }

    public function render()
    {
        return view('livewire.admin.form.user-form');
    }
}
