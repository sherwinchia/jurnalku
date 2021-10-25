<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Traits\Alert;
use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserForm extends Component
{
    use Alert;

    public $user, $roles, $password_confirmation;

    public $edit = false;

    public $buttonText = 'Create';

    protected $rules = [
        'user.name' => 'required|max:80',
        'user.role_id' => 'required',
        'user.password' => 'required|min:6',
        'user.email' => 'required|email|unique:users,email',
        'user.phone_number' => 'nullable|numeric|digits_between:10,15',
        'user.address' => 'nullable|regex:^[#.0-9a-zA-Z\s,-]+$^',
        'password_confirmation' => 'required_with:user.password|same:user.password'
    ];

    public function mount($model = null)
    {
        if (isset($model)) {
            $this->edit = true;
            $this->user = $model;
            $this->buttonText = "Update";

            $this->user->role_id = $this->user->role->id;
        } else {
            $this->user = new User();
            $this->user->role_id = 2;
        }

        $this->roles = Role::all();
    }

    public function generatePassword()
    {
        $this->user['password'] = chr(rand() > 0.5 ? rand(65, 90) : rand(97, 122));
    }

    public function submit()
    {
        if (!$this->edit) {
            $this->validate();
        }

        if ($this->edit) {
            $this->validate([
                'user.name' => 'required|max:80',
                'user.role_id' => 'required',
                'user.password' => 'nullable|min:6',
                'user.phone_number' => 'nullable|numeric|digits_between:10,15',
                'user.address' => 'nullable|regex:^[#.0-9a-zA-Z\s,-]+$^',
                'password_confirmation' => 'required_with:user.password|same:user.password'
            ]);
        }

        $this->user->password ?? $this->user->password = bcrypt($this->user->password);

        $this->password_confirmation = null;

        $this->user->save();

        if ($this->edit) {
            return $this->alert([
                "type" => "success",
                "message" => "User has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "User has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.users.edit", $this->user->id);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.user-form');
    }
}
