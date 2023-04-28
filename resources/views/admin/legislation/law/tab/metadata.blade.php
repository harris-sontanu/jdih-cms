<div class="card-body">

    <div class="alert alert-info border-0">
        Penjelasan dan pedoman tata cara penulisan metadata peraturan dapat dilihat pada <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/permenkumham/24804">Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019 tentang Standar Pengelolaan Dokumen dan Informasi Hukum</a>.
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <div class="mb-3">
                <label class="col-form-label" for="category_id">Jenis Peraturan</label>
                <select name="category_id" id="category_id" autofocus class="select @error('category_id') is-invalid @enderror">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @selected(old('category_id', empty($law) ? null : $law->category_id) == $key)>{{ $value }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label class="col-form-label" for="title">Judul:</label>
                <textarea name="title" id="title" rows="4" spellcheck="false" class="form-control @if ($errors->get('title') OR $errors->get('slug')) is-invalid @endif">{{ old('title', empty($law) ? null : $law->title) }}</textarea>
                <div class="form-text text-muted">Format penulisan: judul ditulis lengkap. Huruf kapital hanya di tahap awal kata. Contoh: Peraturan Gubernur Bali Nomor 39 Tahun 2022 Tentang Sistem Dan Prosedur Pengelolaan Keuangan Daerah.</div>
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
                <label for="code_number" class="col-form-label">Nomor Peraturan</label>
                <input type="text" name="code_number" id="code_number" class="form-control @error('code_number') is-invalid @enderror" value="{{ old('code_number', empty($law) ? null : $law->code_number) }}">
                <div class="form-text text-muted">Kombinasi nomor dan kode peraturan. Contoh: 136/11/HK/2021.</div>
                @error('code_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="number" class="col-form-label">Nomor Urut Peraturan</label>
                <input type="number" name="number" id="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number', empty($law) ? null : $law->number) }}">
                <div class="form-text text-muted">Indeks nomor urutan peraturan yang dipakai. Contoh: 12.</div>
                @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="year" class="col-form-label">Tahun Terbit</label>
                <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', empty($law) ? null : $law->year) }}">
                <div class="form-text text-muted">Tahun diterbitkannya peraturan.</div>
                @error('year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="approved" class="col-form-label">Tgl. Penetapan</label>
                <div class="input-group">
                    <span class="input-group-text @error('approved') is-invalid @enderror"><i class="ph-calendar-blank"></i></span>
                    <input type="text" class="form-control daterange-single @error('approved') is-invalid @enderror" name="approved" value="{{ old('approved', empty($law) ? null : $law->approved) }}">
                    @error('approved')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @endif
                </div>
                <div class="form-text text-muted">Tanggal ditetapkannya peraturan, biasanya tercantum di bagian penutup.</div>
            </div>

            <div class="mb-3">
                <label for="published" class="col-lg-3 col-form-label">Tgl. Pengundangan</label>
                <div class="input-group">
                    <span class="input-group-text @error('published') is-invalid @enderror"><i class="ph-calendar-blank"></i></span>
                    <input type="text" class="form-control daterange-single @error('published') is-invalid @enderror" name="published" value="{{ old('published', empty($law) ? null : $law->published) }}">
                    @error('published')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @endif
                </div>
                <div class="form-text text-muted">Tanggal diundangkannya peraturan, biasanya tercantum di bagian penutup.</div>
            </div>

            <div class="mb-3">
                <label for="author" class="col-lg-3 col-form-label">T.E.U. Badan</label>
                <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', empty($law) ? null : $law->author) }}">
                <div class="form-text text-muted">Tajuk Entri Utama (T.E.U.) adalah lembaga yang bertanggung jawab atas isi peraturan. Contoh: Bali (Provinsi).</div>
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="source" class="col-form-label">Sumber</label>
                <input type="text" name="source" id="source" class="form-control @error('source') is-invalid @enderror" value="{{ old('source', empty($law) ? null : $law->source) }}">
                <div class="form-text text-muted">Format penulisan: Singkatan Lembar Daerah - Tahun - (Nomor Lembar Daerah) : jumlah Hlm. Contoh: BD PROVINSI BALI 2022 (40) : 10 Hlm.</div>
                @error('source')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="place" class="col-form-label">Tempat Terbit</label>
                <input type="text" name="place" id="place" class="form-control @error('place') is-invalid @enderror" value="{{ old('place', empty($law) ? null : $law->place) }}">
                <div class="form-text text-muted">Tempat ditetapkan peraturan, biasanya tercantum di bagian penutup. Contoh: Bali.</div>
                @error('place')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="subject" class="col-form-label">Status</label>
                <div class="form-check-horizontal">
                    @foreach ($lawStatusOptions as $status)                        
                        <label class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="status" value="{{ $status->value }}" @checked(old('status', (empty($law) OR (isset($law) AND $law->status === $status)) ? true : false))>
                            <span class="form-check-label">{{ $status->label() }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="field_id" class="col-form-label">Bidang Hukum</label>
                <div id="field-options">
                    <select name="field_id" id="field_id" class="select-search">
                        <option value="">Pilih Bidang Hukum</option>
                        @foreach ($fields as $key => $value)
                            <option value="{{ $key }}" @selected(old('field_id', empty($law) ? null : $law->field_id) == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-text text-muted">Bidang Hukum dari topik yang dibahas. Contoh: Hukum Adat.
                    @cannot('isAuthor')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#create-field-modal">+ Tambah Bidang Hukum</a>
                    @endcannot
                </div>
                @error('field_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="subject" class="col-form-label">Subjek</label>
                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', empty($law) ? null : $law->subject) }}">
                <div class="form-text text-muted">Format penulisan: Topik/kata kunci dari isi peraturan (ditulis dengan huruf Kapital). Contoh: PENDAFTARAN TANAH - BIAYA.</div>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="language" class="col-form-label">Bahasa</label>
                <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" value="{{ old('language', empty($law) ? null : $law->language) }}">
                <div class="form-text text-muted">Bahasa yang digunakan oleh dokumen. Contoh: Indonesia.</div>
                @error('language')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="location" class="col-form-label">Lokasi</label>
                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', empty($law) ? null : $law->location) }}">
                <div class="form-text text-muted">Tempat fisik peraturan disimpan. Contoh: Biro Hukum Provinsi Bali.</div>
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="matter" class="col-form-label">Urusan Pemerintahan</label>
                <div id="matter-options">
                    <select id="matter" name="matter[]" multiple="multiple" class="form-control select @error('matter') is-invalid @enderror">
                        <option value="">Pilih Bidang Urusan Pemerintahan</option>
                            @if (!empty($law) AND count($law->matters) > 0)
                                @foreach ($matters as $key => $value)
                                    @php $selected = false; @endphp
                                    @foreach ($law->matters as $matter)
                                        @if ($matter->id == $key)
                                            @php $selected = true; @endphp
                                        @endif
                                    @endforeach
                                    <option value="{{ $key }}" @selected($selected)>{{ $value }}</option>
                                @endforeach
                            @else
                                @foreach ($matters as $key => $value)
                                    <option value="{{ $key }}" @selected(old('matter') == $key)>{{ $value }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
                <div class="form-text text-muted">Berdasarkan <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/pp/13250">Peraturan Pemerintah Nomor 38 Tahun 2007</a>. Contoh: Pemberdayaan Perempuan dan Perlindungan Anak.
                    @cannot('isAuthor')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#create-matter-modal">+ Tambah Urusan Pemerintahan</a>
                    @endcannot
                </div>
                @error('matter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="signer" class="col-form-label">Penandatangan</label>
                <input type="text" name="signer" id="signer" class="form-control @error('signer') is-invalid @enderror" value="{{ old('signer', empty($law) ? null : $law->signer) }}">
                <div class="form-text text-muted">Format penulisan: nama pejabat tanpa gelar dan jabatan. Contoh: Wayan Koster.</div>
                @error('signer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="institute_id" class="col-form-label">Pemrakarsa</label>
                <div id="institute-options">
                    <select name="institute_id" id="institute_id" class="select-search">
                        <option value="">Pilih Pemrakarsa</option>
                        @foreach ($institutes as $key => $value)
                            <option value="{{ $key }}" @selected(old('institute_id', empty($law) ? null : $law->institute_id) == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-text text-muted">Instansi yang memprakarsai peraturan. Contoh: Biro Hukum Provinsi Bali.
                    @cannot('isAuthor')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#create-institute-modal">+ Tambah Pemrakarsa</a>
                    @endcannot
                </div>
                @error('institute_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="note" class="col-form-label">Catatan</label>
                <textarea name="note" id="note" rows="4" spellcheck="false" class="form-control @error('note') is-invalid @enderror">{{ old('note', empty($law) ? null : $law->note) }}</textarea>
                @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>
</div>
