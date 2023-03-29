<!-- Main sidebar -->
<div id="sidebar-main" class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <a href="#" class="sidebar-resize-hide me-3">
                    <img src="{{ Auth::guard('admin')->user()->userPictureUrl(Auth::guard('admin')->user()->picture, Auth::guard('admin')->user()->name) }}"" class="rounded-circle" alt="{{ Auth::guard('admin')->user()->name }}" width="40" height="40">
                </a>

                <div class="sidebar-resize-hide flex-fill">
                    <div class="fw-semibold">{{ Auth::guard('admin')->user()->name }}</div>
                    <div class="fs-sm line-height-sm opacity-50">
                        {{ Str::ucfirst(Auth::guard('admin')->user()->role) }}
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>
                            Dasbor
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu {{ request()->is('admin/legislation*') ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-stack"></i> <span>Produk Hukum</span></a>

                    <ul class="nav-group-sub {{ request()->is('admin/legislation*') ? 'show' : 'collapse' }}">
                        <li class="nav-item"><a href="{{ route('admin.legislation.law.index') }}" class="nav-link {{ (request()->is('admin/legislation/law*')) ? 'active' : '' }}">Peraturan</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.monograph.index') }}" class="nav-link {{ (request()->is('admin/legislation/monograph*')) ? 'active' : '' }}">Monografi</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.article.index') }}" class="nav-link {{ (request()->is('admin/legislation/article*')) ? 'active' : '' }}">Artikel</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.judgment.index') }}" class="nav-link {{ (request()->is('admin/legislation/judgment*')) ? 'active' : '' }}">Putusan</a></li>
                        <li class="nav-item-divider"></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.category.index') }}" class="nav-link {{ (request()->is('admin/legislation/category')) ? 'active' : '' }}">Jenis / Bentuk</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.matter.index') }}" class="nav-link {{ (request()->is('admin/legislation/matter')) ? 'active' : '' }}">Urusan Pemerintahan</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.institute.index') }}" class="nav-link {{ (request()->is('admin/legislation/institute')) ? 'active' : '' }}">Pemrakarsa</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.field.index') }}" class="nav-link {{ (request()->is('admin/legislation/field')) ? 'active' : '' }}">Bidang Hukum</a></li>
                        <li class="nav-item-divider"></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.statistic') }}" class="nav-link {{ (request()->is('admin/legislation/statistic')) ? 'active' : '' }}">Statistik</a></li>
                        <li class="nav-item"><a href="{{ route('admin.legislation.log') }}" class="nav-link {{ (request()->is('admin/legislation/log')) ? 'active' : '' }}">Riwayat</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{ (request()->is('admin/news*') OR request()->is('admin/taxonomy/news')) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-newspaper"></i> <span>Berita</span></a>

                    <ul class="nav-group-sub {{ (request()->is('admin/news*') OR request()->is('admin/taxonomy/news')) ? 'show' : 'collapse' }}">
                        <li class="nav-item"><a href="{{ route('admin.news.index') }}" class="nav-link {{ (request()->is('admin/news')) ? 'active' : '' }}">Daftar Berita</a></li>
                        <li class="nav-item"><a href="{{ route('admin.news.create') }}" class="nav-link {{ (request()->is('admin/news/create')) ? 'active' : '' }}">Tambah Berita</a></li>
                        <li class="nav-item"><a href="{{ route('admin.taxonomy.index', ['type' => 'news']) }}" class="nav-link {{ (request()->is('admin/taxonomy/news')) ? 'active' : '' }}">Kategori</a></li>
                    </ul>
                </li>

                {{-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="ph-chats"></i> <span>Forum</span></a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a href="#" class="nav-link">Daftar Topik</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Tambah Topik</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Kategori</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Diskusi</a></li>
                    </ul>
                </li> --}}

                <li class="nav-item nav-item-submenu {{ (request()->is('admin/page*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-note"></i> <span>Halaman</span></a>

                    <ul class="nav-group-sub {{ (request()->is('admin/page*')) ? 'show' : 'collapse' }}">
                        <li class="nav-item"><a href="{{ route('admin.page.index') }}" class="nav-link {{ (request()->is('admin/page')) ? 'active' : '' }}">Daftar Halaman</a></li>
                        <li class="nav-item"><a href="{{ route('admin.page.create') }}" class="nav-link {{ (request()->is('admin/page/create')) ? 'active' : '' }}">Tambah Halaman</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{ (request()->is('admin/media*') OR request()->is('admin/link/youtube')) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-image"></i> <span>Media</span></a>

                    <ul class="nav-group-sub {{ (request()->is('admin/media*') OR request()->is('admin/link/youtube')) ? 'show' : 'collapse' }}">
                        <li class="nav-item"><a href="{{ route('admin.media.slide.index') }}" class="nav-link {{ (request()->is('admin/media/slide')) ? 'active' : '' }}">Slide</a></li>
                        <li class="nav-item"><a href="{{ route('admin.media.image.index') }}" class="nav-link {{ (request()->is('admin/media/image')) ? 'active' : '' }}">Gambar</a></li>
                        <li class="nav-item"><a href="{{ route('admin.media.file.index') }}" class="nav-link {{ (request()->is('admin/media/file')) ? 'active' : '' }}">Berkas</a></li>
                        <li class="nav-item"><a href="{{ route('admin.link.youtube.index') }}" class="nav-link {{ (request()->is('admin/link/youtube')) ? 'active' : '' }}">YouTube</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{ (request()->is('admin/link*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-link-simple"></i> <span>Tautan</span></a>

                    <ul class="nav-group-sub {{ (request()->is('admin/link*')) ? 'show' : 'collapse' }}">
                        <li class="nav-item"><a href="{{ route('admin.link.banner.index') }}" class="nav-link {{ (request()->is('admin/link/banner')) ? 'active' : '' }}">Banner</a></li>
                        <li class="nav-item"><a href="{{ route('admin.link.jdih.index') }}" class="nav-link {{ (request()->is('admin/link/jdih')) ? 'active' : '' }}">JDIH</a></li>
                    </ul>
                </li>

                @cannot('isAuthor')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/employee*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="ph-users"></i> <span>Pegawai</span></a>

                        <ul class="nav-group-sub {{ (request()->is('admin/employee*')) ? 'show' : 'collapse' }}">
                            <li class="nav-item"><a href="{{ route('admin.employee.index') }}" class="nav-link {{ (request()->is('admin/employee')) ? 'active' : '' }}">Daftar Pegawai</a></li>
                            <li class="nav-item"><a href="{{ route('admin.employee.create') }}" class="nav-link {{ (request()->is('admin/employee/create')) ? 'active' : '' }}">Tambah Pegawai</a></li>
                            <li class="nav-item"><a href="{{ route('admin.employee.group.index') }}" class="nav-link {{ (request()->is('admin/employee/group')) ? 'active' : '' }}">Grup</a></li>
                        </ul>
                    </li>
                @endcannot

                <li class="nav-item">
                    <a href="/admin/visitor" class="nav-link {{ request()->is('admin/visitor') ? 'active' : '' }}">
                        <i class="ph-chart-bar"></i>
                        <span>
                            Pengunjung
                        </span>
                    </a>
                </li>


                <li class="nav-item nav-item-submenu {{ (request()->is('admin/questionner*') OR request()->is('admin/statistic/questionner*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-pencil-line"></i> <span>IKM</span></a>

                    <ul class="nav-group-sub {{ (request()->is('admin/questionner*') OR request()->is('admin/statistic/questionner*')) ? 'show' : 'collapse' }}">
                        @cannot('isAuthor')
                            <li class="nav-item"><a href="{{ route('admin.questionner.index') }}" class="nav-link {{ (request()->is('admin/questionner')) ? 'active' : '' }}">Kuisioner</a></li>
                        @endcannot
                        <li class="nav-item"><a href="{{ route('admin.questionner.statistic') }}" class="nav-link {{ (request()->is('admin/questionner/statistic')) ? 'active' : '' }}">Statistik</a></li>
                    </ul>
                </li>

                @cannot('isAuthor')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/user*') OR (request()->is('admin/setting*'))) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="ph-gear"></i> <span>Pengaturan</span></a>

                        <ul class="nav-group-sub {{ (request()->is('admin/user*') OR (request()->is('admin/setting*'))) ? 'show' : 'collapse' }}">
                            <li class="nav-item"><a href="{{ route('admin.setting.index') }}" class="nav-link {{ (request()->is('admin/setting')) ? 'active' : '' }}">Aplikasi</a></li>
                            @can('isAdmin')
                                <li class="nav-item"><a href="{{ route('admin.user.index') }}" class="nav-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">Operator</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcannot

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
