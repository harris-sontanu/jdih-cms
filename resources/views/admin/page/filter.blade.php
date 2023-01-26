<div class="card-body bg-light pb-0">
    <form action="{{ route('admin.page.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Judul" value="{{ Request::get('title') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="body" placeholder="Isi" value="{{ Request::get('body') }}">
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
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="published_at" value="{{ Request::get('published_at') }}" placeholder="Tgl. Terbit">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="user" name="user" class="form-control select">
                        <option value="">Pilih Penulis</option>
                        @foreach ($authors as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('user') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="user" name="user" class="form-control select">
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

