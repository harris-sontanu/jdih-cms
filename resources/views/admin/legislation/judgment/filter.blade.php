<div class="card-body bg-light pb-0">
    <form action="{{ route('admin.legislation.judgment.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="category" id="category" class="select-search">
                        <option value="">Pilih Jenis</option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('category') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Judul" value="{{ Request::get('title') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Nomor Putusan" name="code_number" value="{{ Request::get('code_number') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="published" value="{{ Request::get('published') }}" placeholder="Tgl. Dibacakan">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tempat Peradilan" name="place" value="{{ Request::get('place') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Sumber" name="source" value="{{ Request::get('source') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Subjek" name="subject" value="{{ Request::get('subject') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Bahasa" name="language" value="{{ Request::get('language') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="T.E.U. Badan" name="author" value="{{ Request::get('author') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Status" name="status" value="{{ Request::get('status') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="field" name="field" class="form-control select-search">
                        <option value="">Pilih Bidang Hukum</option>
                        @foreach ($fields as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('field') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Tgl. Posting">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="user" name="user" class="form-control select-search">
                        <option value="">Pilih Operator</option>
                        @foreach ($users as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('user') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <button type="submit" name="filter" value="true" class="btn btn-indigo"><i class="ph-magnifying-glass me-2"></i>Cari</button>
                </div>
            </div>
        </div>

    </form>
</div>

