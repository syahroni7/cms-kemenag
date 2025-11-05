<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category','user')->latest()->paginate(10);
        return view('backend.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('backend.posts.edit', compact('post','categories'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return redirect()->route('posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Berita dihapus.');
    }
}
