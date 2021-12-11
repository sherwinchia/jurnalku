<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Blog;
use Mtownsend\ReadTime\ReadTime;

class BlogForm extends Component
{
    use Alert;

    public $blog;

    public $edit = false;

    public $buttonText = "Create";

    protected $rules = [
        "blog.title" => "required",
        "blog.description" => "required",
        "blog.slug" => "required|regex:/^[a-z0-9-]+$/|unique:blogs,slug",
        "blog.body" => "required",
        "blog.read_minutes" => "required",
        "blog.published_at" => "required",
        "blog.published" => "required|boolean"
    ];

    protected $listeners = ["updateData"];

    public function mount($model = null)
    {
        if (isset($model)) {
            $this->edit = true;
            $this->blog = $model;
            $this->blog->published_at = format_string_date($this->blog->published_at);
            $this->buttonText = "Update";
        } else {
            $this->blog = new Blog();
            $this->blog->published = 0;
        }
    }

    public function titleAdded()
    {
        $slug = $this->blog->title;
        if (isset($slug)) {
            $slug = strtolower(str_replace(' ', '-', $slug));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', "", $slug);
            $this->blog->slug = $slug;
        }
    }

    public function updateData($data)
    {
        try {
            $this->blog->body = $data;
            $readMinutes = (new ReadTime($data, $omitSeconds = true, $abbreviated = false, $wordsPerMinute = 190))->toArray()['minutes'];
            if ($readMinutes > 1) {
                $readMinutes .= ' minutes';
            } else {
                $readMinutes .= ' minute';
            }
            $this->blog->read_minutes = $readMinutes;
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->submit();
    }

    public function submit()
    {
        if (!$this->edit) {
            $this->validate();
        } else {
            $this->validate([
                "blog.title" => "required",
                "blog.description" => "required",
                "blog.slug" => "required|regex:/^[a-z0-9-]+$/|unique:blogs,slug," . $this->blog->id,
                "blog.body" => "required",
                "blog.read_minutes" => "required",
                "blog.published_at" => "required",
                "blog.published" => "required|boolean"
            ]);
        }

        $this->blog->save();

        if ($this->edit) {
            return $this->alert([
                "type" => "success",
                "message" => "Blog has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "Blog has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.blogs.edit", $this->blog->id);
        }
    }

    public function render()
    {
        return view("livewire.admin.blog.blog-form");
    }
}
