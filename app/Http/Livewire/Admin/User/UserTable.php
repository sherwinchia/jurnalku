<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;

class UserTable extends Component
{
    use WithPagination, Alert;

    protected $listeners = ['tableRefresh' => '$refresh'];

    public $search = '';
    public $sortField = 'id';
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["search", "create", "show", "edit", "delete"];
    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Name",
            "field" => "name",
            "sortable" => true,
        ],
        [
            "name" => "Role",
            "relation" => "role.name",
            "sortable" => false,
        ],
        [
            "name" => "Subscription",
            "relation" => "subscription.type",
            "sortable" => false,
        ],
        [
            "name" => "Expiry",
            "relation" => "subscription.expired_at",
            "format" => ["date_to_human", "d F Y"],
            "sortable" => false,
        ],
        [
            "name" => "Action",
            "field" => "action",
            "sortable" => false,
        ],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function showModal($id)
    {
        $this->modalVisible = true;
        $this->encryptedId = $id;
    }

    public function delete()
    {
        try {
            $id = Crypt::decrypt($this->encryptedId);
            User::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "User has been successfully deleted."
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    public function createUser()
    {
        return redirect(route('admin.users.create'));
    }

    public function paginationView()
    {
        return 'admin.partials.pagination';
    }

    public function render()
    {
        return view('livewire.admin.user.user-table', [
            'users' => User::query()
                ->where('id', '!=', auth()->user()->id)
                ->where('name', 'ILIKE', "%{$this->search}%")
                ->with("role")
                ->with("subscription")
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ]);
    }
}
