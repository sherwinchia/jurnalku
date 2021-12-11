<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    const PATH = "user.blog.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        if (!$blog->published || $blog->published_at >= now()) {
            abort(404);
        }
        $other_blogs = Blog::where('published', true)
            ->where('published_at', '<=', now())
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->get()
            ->take(4);
        return view(self::PATH . "show", compact("blog", "other_blogs"));
    }
}
