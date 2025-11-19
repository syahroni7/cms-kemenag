<li>
    <div class="node">
        @if($node->foto)
            <img src="{{ asset('storage/'.$node->foto) }}" 
                 class="img-fluid rounded-circle mb-2" 
                 style="width:70px;height:70px;object-fit:cover;">
        @endif

        <h5>{{ $node->jabatan }}</h5>
        <p>{{ $node->nama }}</p>
    </div>

    @if($node->childrenRecursive->count())
        <ul>
            @foreach ($node->childrenRecursive as $child)
                @include('struktur.node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
