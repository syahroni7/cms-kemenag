<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Kontak;
use App\Models\SocialMedia;
use App\Models\Menu;
use App\Models\Strukturorganisasi; // <-- import model struktur organisasi
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $menus;
    protected $socials;

    public function __construct()
    {
        // Share menu dan sosial ke semua view
        $this->menus = Menu::whereNull('parent_id')
            ->orderBy('order')
            ->with('children')
            ->get();

        $this->socials = SocialMedia::all();

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
            'breadcrumbs' => [], // halaman home tidak perlu breadcrumbs tambahan
        ]);
    }

    /**
     * Halaman Struktur Organisasi
     */
    public function strukturOrganisasi()
    {
        // Struktur utama (hirarki)
        $struktur = Strukturorganisasi::whereNull('parent_id')
            ->where('tipe', 'struktural')
            ->with('children.children')
            ->get();

        // Jabatan fungsional
        $fungsional = Strukturorganisasi::where('tipe', 'fungsional')->get();
        $title = 'Struktur Organisasi';

        return view('frontend.landing.struktur-organisasi.index', compact('struktur', 'fungsional', 'title'));
    }

    /**
     * Halaman Data Pegawai.
     */
    public function datapegawai()
    {
        return view('frontend.landing.data-pegawai.index', [
            'title' => 'Data Pegawai',
            'breadcrumbs' => [
                ['label' => 'Data Pegawai', 'url' => url('/data-pegawai')],
            ],
        ]);
    }

    /**
     * Halaman Kategori (daftar semua kategori).
     */
    public function kategori()
    {
        return view('frontend.landing.kategori.index', [
            'title' => 'Kategori',
            'breadcrumbs' => [
                ['label' => 'Kategori', 'url' => url('/kategori')],
            ],
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
     * Halaman kategori spesifik.
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
            'breadcrumbs' => [
                ['label' => 'Kategori', 'url' => url('/kategori')],
                ['label' => $category->name], // terakhir tidak perlu URL
            ],
        ]);
    }

    /**
     * Fitur pencarian berita.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $posts = Post::where('status', 'published')
            ->where(function ($q2) use ($query) {
                $q2->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('frontend.search', [
            'query' => $query,
            'posts' => $posts,
            'breadcrumbs' => [
                ['label' => 'Pencarian', 'url' => url('/search?q=' . $query)],
            ],
        ]);
    }
}
