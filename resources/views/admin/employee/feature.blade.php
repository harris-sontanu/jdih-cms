<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="dropdown-submenu dropdown-submenu-start">
                    <a href="#" class="dropdown-item">Grup</a>
                    <div class="dropdown-menu">
                        @foreach ($groups as $key => $value)
                            <a href="#" class="dropdown-item trigger" data-route="/admin/employee/trigger" data-action="group" data-val="{{ $key }}">{{ $value }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item trigger" data-route="/admin/employee/trigger" data-confirm="Apakah Anda yakin ingin menghapus pegawai?" data-action="delete">Hapus</a>
            </div>
        </div>
        <a href="{{ route('admin.employee.create') }}" class="btn btn-indigo"><i class="ph-user-plus me-2"></i>Tambah</a>
    </div>
</div>
