@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.legislation.judgment.update', $judgment->id) }}" novalidate enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Inner container -->
            <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

                <!-- Left content -->
                <div class="flex-1 order-2 order-lg-1">

                    <div class="card card-body">
                        <div class="alert alert-info border-0">
                            Penjelasan dan pedoman tata cara penulisan metadata putusan dapat dilihat pada <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/permenkumham/24804">Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019 tentang Standar Pengelolaan Dokumen dan Informasi Hukum</a>.
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">

                                <div class="mb-3">
                                    <label class="col-form-label" for="category_id">Jenis Putusan</label>
                                    <select name="category_id" id="category_id" autofocus class="select @error('category_id') is-invalid @enderror">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $key }}" @selected($judgment->category_id == $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label" for="title">Judul:</label>
                                    <textarea name="title" id="title" rows="4" spellcheck="false" class="form-control @error('title') is-invalid @enderror">{{ $judgment->title }}</textarea>
                                    <div class="form-text text-muted">Format penulisan: Nama jenis putusan - nomor putusan - tahun putusan - para pihak yang berperkara. Contoh: Putusan Mahkamah Agung Nomor 319 PK/Pdt/2016 tahun 2016 Rico Widjaya vs Kementrian Pariwisata dan Ekonomi Kreatif c.q Sekolah Tinggi Pariwisata Bandung, Dkk.</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="code_number" class="col-form-label">Nomor Putusan</label>
                                    <input type="text" name="code_number" id="code_number" class="form-control @error('code_number') is-invalid @enderror" value="{{ $judgment->code_number }}">
                                    <div class="form-text text-muted">Contoh: 319 PK/Pdt/2016.</div>
                                    @error('code_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="number" class="col-form-label">Nomor Urut Putusan</label>
                                    <input type="number" name="number" id="number" class="form-control @error('number') is-invalid @enderror" value="{{ $judgment->number }}">
                                    <div class="form-text text-muted">Indeks nomor urutan putusan yang dipakai. Contoh: 319.</div>
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="justice" class="col-form-label">Jenis Peradilan</label>
                                    <input type="text" name="justice" id="justice" class="form-control @error('justice') is-invalid @enderror" value="{{ $judgment->justice }}">
                                    <div class="form-text text-muted">Jenis peradilan yang memutuskan perkara. Contoh: Mahkamah Agung.</div>
                                    @error('justice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="year" class="col-form-label">Tahun Terbit</label>
                                    <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ $judgment->year }}">
                                    <div class="form-text text-muted">Tahun diterbitkannya putusan.</div>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="published" class="col-form-label">Tgl. Dibacakan</label>
                                    <div class="input-group">
                                        <span class="input-group-text @error('published') is-invalid @enderror"><i class="ph-calendar-blank"></i></span>
                                        <input type="text" class="form-control daterange-single @error('published') is-invalid @enderror" name="published" value="{{ $judgment->published }}">
                                        @error('published')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text text-muted">Tanggal putusan dibacakan.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="place" class="col-form-label">Tempat Peradilan</label>
                                    <input type="text" name="place" id="place" class="form-control @error('place') is-invalid @enderror" value="{{ $judgment->place }}">
                                    <div class="form-text text-muted">Kota tempat perkara diputuskan.</div>
                                    @error('place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="source" class="col-form-label">Sumber</label>
                                    <input type="text" name="source" id="source" class="form-control @error('source') is-invalid @enderror" value="{{ $judgment->source }}">
                                    <div class="form-text text-muted">Contoh: Mahkamah Agung.</div>
                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="col-form-label">Status</label>
                                    <input type="text" name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ $judgment->status }}">
                                    <div class="form-text text-muted">Status putusan pengadilan. Contoh: Tetap.</div>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="field_id" class="col-form-label">Bidang Hukum</label>
                                    <div id="field-options" class="@error('field_id') is-invalid @enderror">
                                        <select name="field_id" id="field_id" class="select-search">
                                            <option value="">Pilih Bidang Hukum</option>
                                            @foreach ($fields as $key => $value)
                                                <option value="{{ $key }}" @selected($judgment->field_id == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-text text-muted">Jenis perkara dari pokok perkara. Contoh: Hukum Perdata. <a href="#" data-bs-toggle="modal" data-bs-target="#create-field-modal">+ Bidang Hukum</a></div>
                                    @error('field_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="language" class="col-form-label">Bahasa</label>
                                    <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" value="{{ $judgment->language }}">
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="col-form-label">T.E.U. Badan</label>
                                    <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ $judgment->author }}">
                                    <div class="form-text text-muted">Lembaga yang bertanggung jawab atas isi putusan. Contoh: Indonesia. Mahkamah Agung.</div>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="col-form-label">Subjek</label>
                                    <textarea name="subject" id="subject" rows="4" spellcheck="false" class="form-control @error('subject') is-invalid @enderror">{{ $judgment->subject }}</textarea>
                                    <div class="form-text text-muted">Pokok perkara dalam putusan.</div>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="note" class="col-form-label">Catatan</label>
                                    <textarea name="note" id="note" rows="4" spellcheck="false" class="form-control @error('note') is-invalid @enderror">{{ $judgment->note }}</textarea>
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
                                        <td class="text-end">{!! $judgment->publicationBadge() !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                        <td class="text-end">{{ $judgment->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                        <td class="text-end">
                                            <abbr class="publish-date-text" data-bs-popup="tooltip" title="{{ $judgment->dateFormatted($judgment->created_at, true) }}">{{ $judgment->dateFormatted($judgment->created_at) }}</abbr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                        <td class="text-end">
                                            <input type="text" class="form-control datetimerange-single text-end  @error('published_at') is-invalid @enderror" name="published_at" placeholder="{{ now()->translatedFormat('d-m-Y H:i') }}" value="{{ empty($judgment->published_at) ? null : $judgment->published_at }}">
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
                                    <label for="master" class="col-form-label">Lampiran</label>
                                    <input type="file" class="form-control @error('master') is-invalid @enderror" name="master">
                                    <div class="form-text text-muted">Format: pdf. Ukuran maks: 2Mb.</div>
                                    @error('master')
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
                                    @forelse ($judgment->logs->take(5) as $log)
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
