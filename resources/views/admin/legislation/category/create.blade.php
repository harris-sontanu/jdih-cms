<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.legislation.category.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis/Bentuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type_id" class="select">
                            <option value="">Pilih Tipe</option>
                            @foreach ($types as $key => $value)
                                <option value="{{ $key }}" @selected(old('type_id') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Peraturan Daerah">
                    </div>
                    <div class="mb-3">
                        <label for="abbrev" class="form-label">Singkatan</label>
                        <input type="text" class="form-control" name="abbrev" id="abbrev" value="{{ old('abbrev') }}" placeholder="PERDA">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode File</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" placeholder="pd">
                    </div>
                    <div class="mb-0">
                        <label for="desc" class="form-label">Deskripsi</label>
                        <textarea name="desc" id="desc" class="form-control" rows="4" placeholder="Peraturan Perundang-undangan yang dibentuk oleh Dewan Perwakilan Rakyat Daerah dengan persetujuan bersama Kepala Daerah (gubernur atau bupati/wali kota)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    <button id="save-btn" type="button" class="btn btn-indigo">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
