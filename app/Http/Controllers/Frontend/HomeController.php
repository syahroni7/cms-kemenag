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
    protected $menus;
    protected $socials;

    public function __construct()
    {
        // Ambil semua menu utama + submenu recursive dari database
        $this->menus = Menu::whereNull('parent_id')
            ->orderBy('order')
            ->with('childrenRecursive')
            ->get();

        // Ambil semua akun sosial media
        $this->socials = SocialMedia::all();

        // Share ke semua view agar tidak perlu dikirim satu per satu
        view()->share([
            'menus' => $this->menus,
            'socials' => $this->socials,
        ]);
    }

    /**
     * Halaman utama.
     */
    public function index()
    {
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

        return view('frontend.layouts.index', [
            'slides' => $slides,
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
        return view('frontend.landing.kategori.index', [
            'title' => 'Kategori',
        ]);
    }

    /**
     * Halaman Kontak.
     */
    public function kontak()
    {
        $kontak = Kontak::first();

        return view('frontend.landing.kontak.index', [
            'title' => 'Kontak',
            'kontak' => $kontak,
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
