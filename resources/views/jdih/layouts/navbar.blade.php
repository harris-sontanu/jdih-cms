<!-- Navigation -->
<div class="navbar shadow">
    <div class="container position-relative px-lg-3">
        <div class="flex-fill overflow-auto overflow-lg-visible scrollbar-hidden">
            <ul class="main-nav nav gap-1 flex-nowrap flex-lg-wrap">
                <li class="nav-item">
                    <a href="/" class="navbar-nav-link rounded {{ request()->is('/') ? 'active fw-bold' : null }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle rounded {{ request()->is('produk-hukum*') ? 'active fw-bold' : null }}" data-bs-toggle="dropdown">
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
                    <a href="index.html" class="navbar-nav-link rounded">
                        Berita
                    </a>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
                        Profil
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item rounded">Visi & Misi</a>
                        <a href="#" class="dropdown-item rounded">Tugas Pokok & Fungsi</a>
                        <a href="#" class="dropdown-item rounded">Struktur Organisasi</a>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
                        Galeri
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item rounded">Foto</a>
                        <a href="#" class="dropdown-item rounded">Video</a>
                    </div>
                </li>

                <li class="nav-item ms-lg-auto">
                    <a href="index.html" class="navbar-nav-link rounded">
                        Kontak
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /navigation -->
