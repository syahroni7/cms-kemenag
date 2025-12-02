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

                        {{-- Nested menu --}}
                        <ul id="menuList" class="nested-menu">
                            @foreach($menus as $menu)
                            @include('backend.admin.pengaturan.menu._menu_item', ['menu' => $menu])
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function makeNestedSortable(el) {
            Sortable.create(el, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                ghostClass: 'sortable-ghost'
            });

            el.querySelectorAll('ul').forEach(function(childUl) {
                makeNestedSortable(childUl);
            });
        }

        makeNestedSortable(document.getElementById('menuList'));

        function serializeMenus(el, parentId = null) {
            let items = [];
            el.querySelectorAll(':scope > li').forEach(function(li, index) {
                let id = parseInt(li.getAttribute('data-id'));
                let safeParentId = (parentId && parentId !== id) ? parseInt(parentId) : null;

                items.push({
                    id: id,
                    parent_id: safeParentId,
                    order: index + 1
                });

                let childrenUl = li.querySelector('ul');
                if (childrenUl) {
                    items = items.concat(serializeMenus(childrenUl, id));
                }
            });
            return items;
        }

        document.getElementById('saveOrderBtn').addEventListener('click', function() {
            let menus = serializeMenus(document.getElementById('menuList'));
            console.log('Menus to save:', menus); // debug

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
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Urutan menu berhasil disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat menyimpan urutan menu.'
                        });
                        console.error(data.error || 'Unknown error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.'
                    });
                });
        });

    });
</script>

<style>
    .nested-menu,
    .nested-menu ul {
        list-style: none;
        padding-left: 20px;
    }

    .nested-menu li {
        padding: 8px 12px;
        margin: 4px 0;
        background: #f8f9fa;
        border: 1px solid #ddd;
        cursor: grab;
    }

    .sortable-ghost {
        opacity: 0.4;
    }
</style>
@endsection