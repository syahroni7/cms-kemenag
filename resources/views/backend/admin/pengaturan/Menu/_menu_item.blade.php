<li data-id="{{ $menu->id }}">
    {{ $menu->name }}
    @if($menu->children->count() > 0)
        <ul>
            @foreach($menu->children as $child)
                @include('backend.admin.pengaturan.menu._menu_item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
