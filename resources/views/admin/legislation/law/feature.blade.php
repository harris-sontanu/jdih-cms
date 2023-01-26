<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Request::get('tab') != 'trash')
                    <div class="dropdown-submenu dropdown-submenu-start">
                        <a href="#" class="dropdown-item">Status</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item trigger" data-route="/admin/legislation/law/trigger" data-action="status" data-val="berlaku">Berlaku</a>
                            <a href="#" class="dropdown-item trigger" data-route="/admin/legislation/law/trigger" data-action="status" data-val="tidak berlaku">Tidak Berlaku</a>
                        </div>
                    </div>
                    <div class="dropdown-submenu dropdown-submenu-start">
                        <a href="#" class="dropdown-item">Jenis</a>
                        <div class="dropdown-menu">
                            @foreach ($categories as $key => $value)
                                <a href="#" class="dropdown-item trigger" data-route="/admin/legislation/law/trigger" data-action="category" data-val="{{ $key }}">{{ Str::title($value) }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="dropdown-submenu dropdown-submenu-start">
                    <a href="#" class="dropdown-item">Ekspor</a>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.legislation.law.export', 'excel') }}" class="dropdown-item export" data-action="excel">Excel</a>
                        <a href="{{ route('admin.legislation.law.export', 'pdf') }}" class="dropdown-item export" data-action="pdf">PDF</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @if (Request::get('tab') == 'sampah')
                    <a href="#" class="dropdown-item trigger" data-route="/admin/legislation/law/trigger" data-confirm="Apakah Anda yakin menghapus peraturan?" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-route="/admin/legislation/law/trigger" data-action="trash">Buang</a>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.legislation.law.create') }}" class="btn btn-indigo"><i class="ph-plus me-2"></i>Tambah</a>
    </div>
</div>
