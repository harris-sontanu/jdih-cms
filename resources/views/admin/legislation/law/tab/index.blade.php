<div class="card">
    <div class="navbar navbar-expand-lg rounded-top border-bottom py-2">
        <div class="container-fluid">
            <ul class="nav navbar-nav flex-row flex-fill" role="tablist">
                <li class="nav-item me-1" role="presentation">
                    <a href="#metadata" data-bs-toggle="tab" role="tab" class="navbar-nav-link rounded active">
                        <div class="d-flex align-items-center mx-lg-1">
                            <i class="ph-code"></i>
                            <span class="d-none d-lg-inline-block ms-2">Metadata</span>
                        </div>
                    </a>
                </li>    
                <li class="nav-item me-1" role="presentation">
                    <a href="#status" data-bs-toggle="tab" role="tab" class="navbar-nav-link rounded">
                        <div class="d-flex align-items-center mx-lg-1">
                            <i class="ph-info"></i>
                            <span class="d-none d-lg-inline-block ms-2">Keterangan Status</span>
                        </div>
                    </a>
                </li>       
                <li class="nav-item me-1" role="presentation">
                    <a href="#legislation" data-bs-toggle="tab" role="tab" class="navbar-nav-link rounded">
                        <div class="d-flex align-items-center mx-lg-1">
                            <i class="ph-tree-structure"></i>
                            <span class="d-none d-lg-inline-block ms-2">Peraturan Terkait</span>
                        </div>
                    </a>
                </li>  
                <li class="nav-item me-1" role="presentation">
                    <a href="#document" data-bs-toggle="tab" role="tab" class="navbar-nav-link rounded">
                        <div class="d-flex align-items-center mx-lg-1">
                            <i class="ph-files"></i>
                            <span class="d-none d-lg-inline-block ms-2">Dokumen Terkait</span>
                        </div>
                    </a>
                </li>             
            </ul>
        </div>
    </div>

    <div class="tab-content flex-1 order-2 order-lg-1">
        <div class="tab-pane fade active show" id="metadata" role="tabpanel">
            
            @include('admin.legislation.law.tab.metadata')
            
        </div>

        <div class="tab-pane fade" id="status" role="tabpanel">

            <div class="card-body">
                <div class="alert alert-info border-0">
                    Keterangan pelengkap dari status utama peraturan yang bertujuan memberikan informasi bahwa suatu peraturan telah dicabut atau pernah diubah oleh peraturan lain.
                </div>
            
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-relation-modal" data-type="status" data-title="Tambah Keterangan Status"><i class="ph-link-simple me-2"></i>Tambah Keterangan Status</button>            
            </div>

            @include('admin.legislation.law.tab.relationship-table', ['relationType' => 'status'])

        </div>

        <div class="tab-pane fade" id="legislation" role="tabpanel">
            
            <div class="card-body">
                <div class="alert alert-info border-0">
                    Dasar yuridis pembentukan peraturan (lihat pada konsideran menimbang). Contoh: Peraturan Presiden Nomor 33 Tahun 2012.
                </div>

                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-relation-modal" data-type="legislation" data-title="Tambah Peraturan Terkait"><i class="ph-link-simple me-2"></i>Tambah Peraturan Terkait</button>
            </div>

            @include('admin.legislation.law.tab.relationship-table', ['relationType' => 'legislation'])

        </div>

        <div class="tab-pane fade" id="document" role="tabpanel">

            <div class="card-body">
                <div class="alert alert-info border-0">
                    Dokumen pendukung pembentukan peraturan tersebut. Contoh: Kajian Hukum, Naskah Akademik.
                </div>
            
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add-relation-modal" data-type="document" data-title="Tambah Dokumen Terkait"><i class="ph-link-simple me-2"></i>Tambah Dokumen Terkait</button>            
            </div>
            
            @include('admin.legislation.law.tab.relationship-table', ['relationType' => 'document'])

        </div>
    </div>
</div>