<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Kontak;
use App\Models\SocialMedia;
use App\Models\Menu;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama website berita instansi.
     */
    public function index()
    {
        // ambil data seperti sebelumnya ...
        $slides = Post::where('status', 'published')
            ->where('is_slider', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        $headline = Post::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('is_slider')->orWhere('is_slider', false);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        $latestPosts = Post::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('is_slider')->orWhere('is_slider', false);
            })
            ->latest('published_at')
            ->skip(3)
            ->take(6)
            ->get();

        $popularCategories = Category::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(5)
            ->get();

        $allPosts = Post::where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        $socials = SocialMedia::all();

        return view('frontend.layouts.index', [
            'slides' => $slides,
            'socials' => $socials,
            'headline' => $headline,
            'latestPosts' => $latestPosts,
            'popularCategories' => $popularCategories,
            'posts' => $allPosts,
        ]);
    }

    /**
     * Halaman kategori.
     */
    public function kategori()
    {
        $socials = SocialMedia::all();

        return view('frontend.landing.kategori.index', [
            'title' => 'Kategori',
            'socials' => $socials, // <-- tambah ini supaya socials tersedia
        ]);
    }

    /**
     * Halaman Kontak.
     */
    public function kontak()
    {
        $kontak = Kontak::first();
        $socials = SocialMedia::all();  // Ambil semua data sosial media

        return view('frontend.landing.kontak.index', [
            'title' => 'Kontak',
            'kontak' => $kontak,
            'socials' => $socials,  // Kirim ke view agar footer dapat data sosial media
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

        $socials = SocialMedia::all();

        return view('frontend.category', [
            'category' => $category,
            'posts' => $posts,
            'socials' => $socials, // <-- tambah ini juga
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

        $socials = SocialMedia::all();

        return view('frontend.search', [
            'query' => $query,
            'posts' => $posts,
            'socials' => $socials, // <-- tambah ini supaya socials tersedia
        ]);
    }
}
