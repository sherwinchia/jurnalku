<?php
namespace App\Http\Livewire\Admin\Table;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subscription;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class SubscriptionTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $columns = [
        [
            "field" => "id",
            "sortable" => true, 
        ],
        [
            "field" => "action",
            "sortable" => false,
            "type" => ["delete", "edit"]
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

        try{
            $id = Crypt::decrypt($this->encryptedId);
            Subscription::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Subscription has been successfully deleted."
            ]);
        } catch(\Illuminate\Database\QueryException $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    public function createSubscription()
    {
        return redirect(route("admin.subscriptions.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.table.subscription-table", [
            "subscriptions" => Subscription::query()
                ->where("id", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}