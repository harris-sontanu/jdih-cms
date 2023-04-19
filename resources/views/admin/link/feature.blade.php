<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-submenu dropdown-submenu-start">
                    <a href="#" class="dropdown-item">Publikasi</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item trigger" data-route="/admin/link/trigger" data-type="{{ $type }}" data-action="publication" data-val="publish">Tayang</a>
                        <a href="#" class="dropdown-item trigger" data-route="/admin/link/trigger" data-type="{{ $type }}" data-action="publication" data-val="unpublish">Tidak Tayang</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item trigger" data-route="/admin/link/trigger" data-type="{{ $type }}" data-confirm="Apakah Anda yakin menghapus {{ $type }}?" data-action="delete">Hapus</a>
            </div>
        </div>
        <button type="button" class="btn btn-indigo" data-bs-toggle="modal" data-bs-target="#create-modal"><i class="ph-plus me-2"></i>Tambah</button>
    </div>
</div>
