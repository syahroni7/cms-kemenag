@php
    $isActive = false;
    $url = trim($menu->url ?? '', '/');

    if ($menu->url === '/' && request()->is('/')) $isActive = true;
    if ($menu->url !== '/' && $url && request()->is($url . '*')) $isActive = true;

    if ($menu->children->count()) {
        foreach ($menu->children as $child) {
            $childUrl = trim($child->url ?? '', '/');
            if ($child->url === '/' && request()->is('/')) { $isActive = true; break; }
            if ($child->url !== '/' && $childUrl && request()->is($childUrl . '*')) { $isActive = true; break; }
        }
    }
@endphp

<li data-id="{{ $menu->id }}" class="{{ $menu->children->count() ? 'dropdown' : '' }} {{ $isActive ? 'active' : '' }}">
    <a class="{{ $isActive ? 'active' : '' }}" href="{{ $menu->children->count() ? '#' : ($menu->url ?? '#') }}">
        @if ($menu->icon)
            <i class="{{ $menu->icon }}"></i>
        @endif
        <span>{{ $menu->name }}</span>
        @if ($menu->children->count())
            <i class="bi bi-chevron-down toggle-dropdown"></i>
        @endif
    </a>

    @if ($menu->children->count())
        <ul class="menu-list {{ $isActive ? 'active' : '' }}">
            @foreach ($menu->children as $child)
                @include('components.navbar', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
