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

            @include('admin.legislation.law.tab.status-relationship')

        </div>

        <div class="tab-pane fade" id="legislation" role="tabpanel">
            
            @include('admin.legislation.law.tab.law-relationship')

        </div>

        <div class="tab-pane fade" id="document" role="tabpanel">
            
            @include('admin.legislation.law.tab.document-relationship')

        </div>
    </div>
</div>