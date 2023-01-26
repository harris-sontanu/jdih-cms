<div class="card-body bg-light pb-0">
    <form action="{{ route('admin.user.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{ Request::get('name') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ Request::get('email') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="role" class="select">
                        <option value="">Pilih Level</option>
                        @foreach ($roles as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('role') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Telepon" name="phone" value="{{ Request::get('phone') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Website" name="www" value="{{ Request::get('www') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="last_logged_in_at" value="{{ Request::get('last_logged_in_at') }}" placeholder="Login Terakhir">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Terdaftar">
                    </div>
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
