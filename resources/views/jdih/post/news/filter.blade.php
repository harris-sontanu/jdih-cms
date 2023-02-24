<!-- Filter -->
<div class="card shadow-lg">
    <div class="sidebar-section-header">
        <h5 class="mb-0">Cari Berita</h5>
    </div>

    <div class="sidebar-section-body">
        <div class="form-control-feedback form-control-feedback-end">
            <input type="search" class="form-control" placeholder="Cari...">
            <div class="form-control-feedback-icon">
                <i class="ph-magnifying-glass"></i>
            </div>
        </div>
    </div>

    <div class="sidebar-section-header">
        <h5 class="mb-0">Kategori</h5>
    </div>

    <div class="nav nav-sidebar">
        @foreach ($taxonomies as $taxonomy)            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="ph-file-text me-2"></i>
                    {{ $taxonomy->name }}
                    <span class="badge bg-teal bg-opacity-10 text-teal rounded-pill ms-auto">{{ $taxonomy->posts->count() }}</span>
                </a>
            </li>
        @endforeach
    </div>

</div>
