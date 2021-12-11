<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    const PATH = "admin.blog.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(Blog $blog)
    {
        return view(self::PATH . "show", compact("blog"));
    }

    public function edit(Blog $blog)
    {
        return view(self::PATH . "edit", compact("blog"));
    }
}
