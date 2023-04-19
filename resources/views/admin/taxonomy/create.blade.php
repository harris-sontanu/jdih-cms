<!-- Modal -->
<div class="modal fade" id="create-taxonomy-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form id="insert-taxonomy-form" action="{{ route('admin.taxonomy.store', ['type' => $type]) }}" method="post" novalidate>
                @csrf
                <input type="hidden" name="ajax" value="true">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-0">
                        <label for="name" class="form-label">Nama</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="Penyuluhan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-indigo">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
