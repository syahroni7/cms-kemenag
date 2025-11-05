<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama website berita instansi.
     */
    public function index()
    {
        // Berita headline (dipilih dari 3 berita terakhir dengan status 'published')
        $headline = Post::where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Berita terbaru (selain headline)
        $latestPosts = Post::where('status', 'published')
            ->latest('published_at')
            ->skip(3)
            ->take(6)
            ->get();

        // Kategori populer (berdasarkan jumlah artikel terbanyak)
        $popularCategories = Category::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(5)
            ->get();

        // Semua berita untuk pagination di bawah
        $allPosts = Post::where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        // Return ke tampilan beranda
        return view('frontend.layouts.index', [
            'headline' => $headline,
            'latestPosts' => $latestPosts,
            'popularCategories' => $popularCategories,
            'posts' => $allPosts,
        ]);
    }

    /**
     * Filter berita berdasarkan kategori.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.category', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }

    /**
     * Fitur pencarian berita berdasarkan judul atau isi.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $posts = Post::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('frontend.search', [
            'query' => $query,
            'posts' => $posts,
        ]);
    }
}
