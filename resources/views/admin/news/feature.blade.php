<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Request::get('tab') != 'trash')
                    @if ($taxonomies->count() > 0)                 
                        <div class="dropdown-submenu dropdown-submenu-start">
                            <a href="#" class="dropdown-item">Kategori</a>
                            <div class="dropdown-menu">
                                @foreach ($taxonomies as $key => $value)
                                    <a href="#" class="dropdown-item trigger" data-route="/admin/news/trigger" data-action="taxonomy" data-val="{{ $key }}">{{ Str::title($value) }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
                <div class="dropdown-divider"></div>
                @if (Request::get('tab') == 'sampah')
                    <a href="#" class="dropdown-item trigger" data-route="/admin/news/trigger" data-confirm="Apakah Anda yakin menghapus berita?" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-route="/admin/news/trigger" data-action="trash">Buang</a>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-indigo"><i class="ph-plus me-2"></i>Tambah</a>
    </div>
</div>
