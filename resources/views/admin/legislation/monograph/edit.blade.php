@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.legislation.monograph.update', $monograph->id) }}" novalidate enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Inner container -->
            <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

                <!-- Left content -->
                <div class="flex-1 order-2 order-lg-1">

                    <div class="card card-body">
                        <div class="alert alert-info border-0">
                            Penjelasan dan pedoman tata cara penulisan metadata monografi dapat dilihat pada <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/permenkumham/24804">Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019 tentang Standar Pengelolaan Dokumen dan Informasi Hukum</a>.
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">

                                <div class="mb-3">
                                    <label class="col-form-label" for="category_id">Jenis Monografi</label>
                                    <select name="category_id" id="category_id" autofocus class="select @error('category_id') is-invalid @enderror">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $key }}" @selected($monograph->category_id == $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label" for="title">Judul:</label>
                                    <textarea name="title" id="title" rows="4" spellcheck="false" class="form-control @if ($errors->get('title') OR $errors->get('slug')) is-invalid @endif">{{ $monograph->title }}</textarea>
                                    <div class="form-text text-muted">Format penulisan: Huruf kapital hanya diawal judul, selebihnya huruf kecil. Contoh: Pengantar hukum adat bali.</div>
                                    @if ($errors->get('title') OR $errors->get('slug'))
                                        <ul class="invalid-feedback list-unstyled">
                                            @foreach ($errors->get('title') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            @foreach ($errors->get('slug') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="year" class="col-form-label">Tahun Terbit</label>
                                    <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ $monograph->year }}">
                                    <div class="form-text text-muted">Tahun diterbitkannya monografi.</div>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edition" class="col-form-label">Edisi</label>
                                    <input type="text" name="edition" id="edition" class="form-control @error('edition') is-invalid @enderror" value="{{ $monograph->edition }}">
                                    <div class="form-text text-muted">Contoh: Cet. 1.</div>
                                    @error('edition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="call_number" class="col-form-label">Nomor Panggil</label>
                                    <input type="text" name="call_number" id="call_number" class="form-control @error('call_number') is-invalid @enderror" value="{{ $monograph->call_number }}">
                                    <div class="form-text text-muted">Format penulisan: (nomor klasifikasi) + (3 huruf awal nama pengarang) + (huruf awal judul). Contoh: 346 THA a.</div>
                                    @error('call_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="place" class="col-form-label">Tempat Terbit</label>
                                    <input type="text" name="place" id="place" class="form-control @error('place') is-invalid @enderror" value="{{ $monograph->place }}">
                                    <div class="form-text text-muted">Contoh: Bali.</div>
                                    @error('place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="publisher" class="col-form-label">Penerbit</label>
                                    <input type="text" name="publisher" id="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ $monograph->publisher }}">
                                    <div class="form-text text-muted">Contoh: CV. Balemedia.</div>
                                    @error('publisher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="desc" class="col-form-label">Deskripsi Fisik</label>
                                    <input type="text" name="desc" id="desc" class="form-control @error('desc') is-invalid @enderror" value="{{ $monograph->desc }}">
                                    <div class="form-text text-muted">Format penulisan: Jumlah halaman romawi, jumlah halaman. ; tinggi buku. Contoh: X, 253 HLM. ; 23CM.</div>
                                    @error('desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="field_id" class="col-form-label">Bidang Hukum</label>
                                    <div id="field-options" class="@error('field_id') is-invalid @enderror">
                                        <select name="field_id" id="field_id" class="select-search">
                                            <option value="">Pilih Bidang Hukum</option>
                                            @foreach ($fields as $key => $value)
                                                <option value="{{ $key }}" @selected($monograph->field_id == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-text text-muted">Contoh: Hukum Adat.
                                        @cannot('isAuthor')
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#create-field-modal">Tambah Bidang Hukum</a>
                                        @endcannot
                                    </div>
                                    @error('field_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isbn" class="col-form-label">ISBN</label>
                                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ $monograph->isbn }}">
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="index_number" class="col-form-label">Eksemplar</label>
                                    <input type="text" name="index_number" id="index_number" class="form-control @error('index_number') is-invalid @enderror" value="{{ $monograph->index_number }}">
                                    @error('index_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="language" class="col-form-label">Bahasa</label>
                                    <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" value="{{ $monograph->language }}">
                                    <div class="form-text text-muted">Bahasa yang digunakan oleh monografi. Contoh: Indonesia.</div>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="col-form-label">Lokasi</label>
                                    <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ $monograph->location }}">
                                    <div class="form-text text-muted">Tempat fisik monografi disimpan. Contoh: Biro Hukum Provinsi Bali.</div>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="col-form-label">T.E.U. Orang/Badan</label>
                                    <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ $monograph->author }}">
                                    <div class="form-text text-muted">Format penulisan: Nama pengarang (tanpa gelar dan dibalik). Contoh: THAMRIN, HUSNI.</div>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="col-form-label">Subjek</label>
                                    <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ $monograph->subject }}">
                                    <div class="form-text text-muted">Format penulisan: Topik/kata kunci dari isi monografi (ditulis dengan huruf Kapital). Contoh: HUKUM ADAT.</div>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="note" class="col-form-label">Catatan</label>
                                    <textarea name="note" id="note" rows="4" spellcheck="false" class="form-control @error('note') is-invalid @enderror">{{ $monograph->note }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- /left content -->

                <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                    <div class="sidebar-content">

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</span>
                            </div>

                            <table class="table table-borderless my-2 table-xs">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-tag me-2"></i>Status:</td>
                                        <td class="text-end">{!! $monograph->publicationBadge() !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                        <td class="text-end">{{ $monograph->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                        <td class="text-end">
                                            <abbr class="publish-date-text" data-bs-popup="tooltip" title="{{ $monograph->dateFormatted($monograph->created_at, true) }}">{{ $monograph->dateFormatted($monograph->created_at) }}</abbr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                        <td class="text-end">
                                            <input type="text" class="form-control datetimerange-single text-end  @error('published_at') is-invalid @enderror" name="published_at" placeholder="{{ now()->translatedFormat('d-m-Y H:i') }}" value="{{ empty($monograph->published_at) ? null : $monograph->published_at }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" name="draft" class="btn btn-link px-0">Ubah ke Draf</button>
                                <button type="submit" name="publish" class="btn btn-indigo">Ubah</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-image-square me-2"></i>Sampul</span>
                            </div>

                            <div class="card-img-actions mx-1 mt-1">
                                <img id="cover-img" class="card-img img-fluid" src="{{ $monograph->coverThumbUrl }}" alt="{{ $monograph->title }}">
                            </div>

                            @empty ($monograph->coverId)
                                <div class="card-body">
                                    <input id="cover-input" type="file" class="form-control @error('cover') is-invalid @enderror" name="cover">
                                    <div class="form-text text-muted">Format: gif, png, jpg, jpeg, bmp, svg, webp. Ukuran maks: 2Mb.</div>
                                    @error('cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="d-flex align-items-start flex-nowrap">
                                        <div>
                                            <div class="fw-semibold me-2">{{ $monograph->coverName }}</div>
                                        </div>

                                        <div class="d-inline-flex ms-auto">
                                            <a role="button" class="text-body ms-2 delete-document" data-bs-popup="tooltip" title="Hapus" data-route="{{ route('admin.legislation.document.destroy', $monograph->coverId) }}"><i class="ph-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endempty
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <span class="fw-semibold"><i class="ph-file-text me-2"></i>Dokumen</span>
                            </div>

                            @if ($attachment)
                                <div class="sidebar-section-body">
                                    <div class="d-flex align-items-start">
                                        <div class="me-2">
                                            <i class="{{ $attachment->extClass; }} ph-2x"></i>
                                        </div>

                                        <div class="flex-fill overflow-hidden">
                                            <a href="{{ $attachment->source }}" class="fw-semibold text-body text-truncate" target="_blank">{{ $attachment->name; }}</a>
                                            <ul class="list-inline list-inline-bullet fs-sm text-muted mb-0">
                                                <li class="list-inline-item me-1">{{ $attachment->typeTranslate }}</li>
                                                <li class="list-inline-item mx-1"><a role="button" class="dirdurdaeng" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $attachment->id }}">Ubah</a></li>
                                                <li class="list-inline-item ms-1"><a role="button" class="delete-document" title="Hapus" data-route="{{ route('admin.legislation.document.destroy', $attachment->id) }}">Hapus</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else

                                <div class="sidebar-section-body pt-0">
                                    <label for="attachment" class="col-form-label">Lampiran</label>
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment">
                                    <div class="form-text text-muted">Format: pdf. Ukuran maks: 2Mb.</div>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <h5 class="mb-0"><i class="ph-clock-counter-clockwise me-2"></i>Riwayat</h5>
                            </div>

                            <div class="sidebar-section-body media-chat-scrollable">
                                <div class="list-feed">
                                    @forelse ($monograph->logs->take(5) as $log)
                                        <div class="list-feed-item">
                                            <span class="fw-semibold">{{ $log->user->name }}</span> {!! $log->message !!}
                                            <div class="text-muted fs-sm">{{ $log->timeDifference($log->created_at) }}</div>
                                        </div>
                                    @empty
                                        <p class="mb-0">Belum ada riwayat</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /sidebar content -->

                </div>
                <!-- /sidebar -->

            </div>

        </form>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.legislation.field.create')
@endsection

@section('script')
    @include('admin.legislation.script')
@endsection
