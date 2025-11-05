@extends('frontend.layouts.master')

@section('title', 'Beranda')

@section('content')
<div class="container mt-4">

    {{-- Headline --}}
    <section class="headline mb-5">
        <h2>Berita Headline</h2>
        <div class="row">
            @foreach($headline as $post)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('frontend.posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-truncate">{{ Str::limit($post->content, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Latest Posts --}}
    <section class="latest-posts mb-5">
        <h2>Berita Terbaru</h2>
        <div class="row">
            @foreach($latestPosts as $post)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('frontend.posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-truncate">{{ Str::limit($post->content, 80) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Popular Categories --}}
    <section class="popular-categories mb-5">
        <h2>Kategori Populer</h2>
        <div class="d-flex flex-wrap gap-2">
            @foreach($popularCategories as $category)
                <a href="{{ route('frontend.categories.show', $category->slug) }}" class="btn btn-outline-primary">
                    {{ $category->name }} ({{ $category->posts_count }})
                </a>
            @endforeach
        </div>
    </section>

    {{-- Semua Berita (Pagination) --}}
    <section class="all-posts mb-5">
        <h2>Semua Berita</h2>
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('frontend.posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-truncate">{{ Str::limit($post->content, 80) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </section>

</div>
@endsection
