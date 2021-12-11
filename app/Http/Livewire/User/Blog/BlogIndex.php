<?php

namespace App\Http\Livewire\User\Blog;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public function mount()
    {
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view('livewire.user.blog.blog-index', [
            "blogs" => Blog::query()->where('published', true)->where('published_at', '<=', now())->latest()->paginate(10)
        ]);
    }
}
