<section id="blog-hero" class="blog-hero section">
    <div class="container-fluid p-0" data-aos="fade">

        @if($slides->count() > 0)
            <div class="blog-hero-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                        "loop": true,
                        "speed": 1000,
                        "effect": "fade",
                        "autoplay": { "delay": 5000 },
                        "slidesPerView": 1,
                        "navigation": {
                            "nextEl": ".swiper-button-next",
                            "prevEl": ".swiper-button-prev"
                        }
                    }
                </script>

                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                        <div class="swiper-slide">
                            <div class="blog-hero-item">
                                <img src="{{ asset('blogy-assets/img/blog/' . ($slide->image ?? 'default.webp')) }}"
                                     alt="{{ $slide->title }}" class="img-fluid">

                                <div class="blog-hero-content">
                                    <span class="category">{{ $slide->category->name ?? 'Uncategorized' }}</span>
                                    <h1>{{ $slide->title }}</h1>

                                    <div class="meta">
                                        <span class="author">BY <a href="#">{{ $slide->author->name ?? 'Admin' }}</a></span>
                                        <span class="date">{{ optional($slide->published_at)->format('d M, Y') }}</span>
                                        <span class="read-time">{{ $slide->read_time ?? '3 Minute Read' }}</span>
                                        <span class="views">{{ number_format($slide->views ?? 0) }} views</span>
                                    </div>

                                    <a href="{{ route('blog.show', $slide->slug) }}" class="read-more">
                                        Continue Reading <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        @else
            {{-- 🔹 Fallback jika tidak ada data --}}
            <div class="text-center py-5 bg-light">
                <img src="{{ asset('blogy-assets/img/empty-slider.svg') }}" alt="No slides available" width="200" class="mb-3">
                <h4 class="text-muted">Belum ada artikel untuk ditampilkan di slider</h4>
                <p class="text-secondary">Silakan tambahkan artikel baru agar muncul di bagian ini.</p>
            </div>
        @endif

    </div>
</section>
