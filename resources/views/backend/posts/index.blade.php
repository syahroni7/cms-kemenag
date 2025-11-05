@extends('backend.layouts.master')
@section('title', 'Daftar Berita')
@section('content')
<h3>Daftar Berita</h3>
<a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">+ Tambah Berita</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $p)
        <tr>
            <td>{{ $p->title }}</td>
            <td>{{ $p->category->name ?? '-' }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>
                <a href="{{ route('posts.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('posts.destroy', $p->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $posts->links() }}
@endsection
