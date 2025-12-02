@extends('backend.layouts.admin.master')
@section('title', $title)

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ $br1 }}</a></li>
                <li class="breadcrumb-item active">{{ $br2 }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>

                        {{-- Drag & Drop Menu --}}
                        <ul id="menuList">
                            @foreach($menus as $menu)
                            <li data-id="{{ $menu->id }}">{{ $menu->name }}</li>
                            @endforeach
                        </ul>

                        <button id="saveOrderBtn" class="btn btn-primary mt-3">Simpan Urutan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('_scripts')
<!-- Sortable.js -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var menuList = document.getElementById('menuList');

        // Inisialisasi Sortable
        Sortable.create(menuList, {
            animation: 150,
            ghostClass: 'sortable-ghost'
        });

        // Tombol simpan urutan
        document.getElementById('saveOrderBtn').addEventListener('click', function() {
            var menus = [];

            menuList.querySelectorAll('li').forEach(function(li, index) {
                menus.push({
                    id: li.getAttribute('data-id'),
                    parent_id: null, // Top level menu, kalau nested bisa diubah
                    order: index + 1
                });
            });

            fetch("{{ route('pengaturan-menu.updateOrder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        menus: menus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Urutan menu berhasil disimpan!');
                    } else {
                        alert('Terjadi kesalahan saat menyimpan urutan menu.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan pada server.');
                });
        });
    });
</script>

<style>
    #menuList li {
        cursor: grab;
        padding: 8px 12px;
        margin: 4px 0;
        background: #f8f9fa;
        border: 1px solid #ddd;
        list-style: none;
    }

    .sortable-ghost {
        opacity: 0.4;
    }
</style>
@endsection