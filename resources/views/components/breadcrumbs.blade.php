@props(['breadcrumbs' => []])

@if (!empty($breadcrumbs))
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">

        {{-- Home --}}
        <li class="breadcrumb-item">
            <a href="/">
                <i class="bi bi-house"></i> Beranda
            </a>
        </li>

        {{-- Dynamic Breadcrumb Items --}}
        @foreach ($breadcrumbs as $item)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"
                @if($loop->last) aria-current="page" @endif>

                {{-- Jika bukan item terakhir --}}
                @if (!$loop->last)
                    <a href="{{ is_string($item['url'] ?? null) ? $item['url'] : '#' }}">
                        @if (!empty($item['icon']))
                            <i class="{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['label'] ?? '' }}
                    </a>

                {{-- Item terakhir --}}
                @else
                    @if (!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    {{ $item['label'] ?? '' }}
                @endif

            </li>
        @endforeach
    </ol>
</nav>
@endif
