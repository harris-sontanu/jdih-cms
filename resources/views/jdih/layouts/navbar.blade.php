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
                    <a href="#" class="navbar-nav-link dropdown-toggle fw-semibold rounded {{ request()->is('profil*') ? 'active fw-bold' : 'fw-semibold' }}" data-bs-toggle="dropdown">
                        Profil
                    </a>

                    <div class="dropdown-menu">
                        <a href="{{ route('profile', 'visi-misi') }}" class="dropdown-item {{ request()->is('profil/visi-misi*') ? 'active' : null }}">Visi & Misi</a>
                        <a href="{{ route('profile', 'tugas-pokok-fungsi') }}" class="dropdown-item {{ request()->is('profil/tugas-pokok-fungsi*') ? 'active' : null }}">Tugas Pokok & Fungsi</a>
                        <a href="{{ route('profile', 'struktur-organisasi') }}" class="dropdown-item {{ request()->is('profil/struktur-organisasi*') ? 'active' : null }}">Struktur Organisasi</a>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle fw-semibold rounded" data-bs-toggle="dropdown">
                        Galeri
                    </a>

                    <div class="dropdown-menu">
                        <a href="{{ route('gallery.photo') }}" class="dropdown-item {{ request()->is('galeri/foto*') ? 'active' : null }}">Foto</a>
                        <a href="{{ route('gallery.video') }}" class="dropdown-item {{ request()->is('galeri/video*') ? 'active' : null }}">Video</a>
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
