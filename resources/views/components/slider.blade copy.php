<section class="hero-slider">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @foreach ($slides as $slide)
            <div class="swiper-slide relative">
                <img src="{{ asset('blogy-assets/img/blog/' . $slide->image) }}" alt="{{ $slide->title }}">
                <div class="hero-caption">
                    <h1 class="hero-title">{{ $slide->title }}</h1>
                    <p class="hero-text">{{ $slide->description }}</p>
                    @if ($slide->button_text && $slide->button_link)
                    <a href="{{ $slide->button_link }}" class="hero-btn">{{ $slide->button_text }}</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigasi dan pagination -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper(".heroSwiper", {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        speed: 900,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
    });
</script>