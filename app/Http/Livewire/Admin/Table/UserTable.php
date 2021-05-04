<?php

namespace App\Http\Livewire\Admin\Table;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    protected $listeners = ['tableRefresh' => '$refresh'];

    public $search = '';
    public $sortField = 'id';
    public $sortAsc = true;
    public $perPage = 10;

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

    public function paginationView()
    {
        return 'admin.partials.pagination';
    }

    public function render()
    {
        return view('livewire.admin.table.user-table', [
            'users' => User::query()
                ->where('id', '!=', auth()->user()->id)
                ->where('name', 'LIKE', "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ]);
    }
}
