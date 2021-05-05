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

    public $slug;
    public $name;
    public $phone_number;
    public $address;

    public $email;
    public $password;

    public $role_id;
    public $roles;

    public $edit;

    public $buttonText = 'Create';

    protected $rules = [
        'name' => 'required|regex:/^[A-Z]+$/i|max:80',
        'role_id' => 'required',
        'password' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable| numeric | starts_with: 6,0',
        'address' => 'nullable|regex:/(^[-0-9A-Za-z.,\/ ]+$)/'
    ];


    public function mount($userId = null)
    {
        $this->edit = isset($userId) ? true : false;

        if (isset($userId)) {
            $this->user = User::findOrFail($userId);
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
                'name' => 'required|regex:/^[A-Z]+$/i|max:80',
                'role_id' => 'required',
                'password' => 'nullable',
                'phone_number' => 'nullable| numeric | starts_with: 6,0',
                'address' => 'nullable|regex:/(^[-0-9A-Za-z.,\/ ]+$)/'
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
            return redirect()->route('admin.users.index');
        } else {
            User::create($data);
            session()->flash('success', 'User successfully created.');
            return redirect()->route('admin.users.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.form.user-form');
    }
}
