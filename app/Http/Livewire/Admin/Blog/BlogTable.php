<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blog;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class BlogTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "created_at";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["search", "create", "edit", "show", "delete"];
    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Title",
            "field" => "title",
            "sortable" => true,
        ],
        [
            "name" => "Published At",
            "field" => "published_at",
            "sortable" => true,
            "format" => ["date_to_human", "d F Y"],
        ],
        [
            "name" => "Published",
            "field" => "published",
            "sortable" => true,
            "format" => ["get_boolean_value"]
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
            Blog::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Blog has been successfully deleted."
            ]);
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    private function decrypt(string $string)
    {
        try {
            return Crypt::decrypt($string);
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function createBlog()
    {
        return redirect(route("admin.blogs.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.blog.blog-table", [
            "blogs" => Blog::query()
                ->where("title", "ILIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}
