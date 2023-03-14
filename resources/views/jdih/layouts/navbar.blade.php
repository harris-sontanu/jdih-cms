<!-- Navigation -->
<div class="navbar navbar-sm sticky-top shadow py-1">
    <div class="container position-relative px-lg-3">
        <div class="flex-fill overflow-auto overflow-lg-visible scrollbar-hidden">
            <ul class="main-nav nav gap-1 flex-nowrap flex-lg-wrap">
                <li class="nav-item">
                    <a href="/" class="navbar-nav-link rounded {{ request()->is('/') ? 'active fw-bold' : 'fw-semibold' }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle rounded {{ request()->is('produk-hukum*') ? 'active fw-bold' : 'fw-semibold' }}" data-bs-toggle="dropdown">
                        Produk Hukum
                    </a>

                    <div class="dropdown-menu">
                        <a href="{{ route('legislation.law.index') }}" class="dropdown-item {{ request()->is('produk-hukum/peraturan-perundang-undangan*') ? 'active' : null }}">Peraturan Perundang-undangan</a>
                        <a href="{{ route('legislation.monograph.index') }}" class="dropdown-item {{ request()->is('produk-hukum/monografi-hukum*') ? 'active' : null }}">Monografi Hukum</a>
                        <a href="{{ route('legislation.article.index') }}" class="dropdown-item {{ request()->is('produk-hukum/artikel-hukum*') ? 'active' : null }}">Artikel Hukum</a>
                        <a href="{{ route('legislation.judgment.index') }}" class="dropdown-item {{ request()->is('produk-hukum/putusan-pengadilan*') ? 'active' : null }}">Putusan Pengadilan</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('news.index') }}" class="navbar-nav-link fw-semibold rounded {{ request()->is('berita*') ? 'active fw-bold' : 'fw-semibold' }}">
                        Berita
                    </a>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle fw-semibold rounded" data-bs-toggle="dropdown">
                        Profil
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Visi & Misi</a>
                        <a href="#" class="dropdown-item">Tugas Pokok & Fungsi</a>
                        <a href="#" class="dropdown-item">Struktur Organisasi</a>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle fw-semibold rounded" data-bs-toggle="dropdown">
                        Galeri
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Foto</a>
                        <a href="#" class="dropdown-item">Video</a>
                    </div>
                </li>

                <li class="nav-item ms-lg-auto">
                    <a href="index.html" class="navbar-nav-link fw-semibold rounded">
                        Kontak
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /navigation -->
