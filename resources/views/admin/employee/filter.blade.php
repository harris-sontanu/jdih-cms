<div class="card-body bg-light pb-0">
    <form action="{{ route('admin.employee.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{ Request::get('name') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Jabatan" name="position" value="{{ Request::get('position') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="group" id="group" class="select">
                        <option value="">Pilih Grup</option>
                        @foreach ($groups as $key => $value)
                            <option value="{{ $key }}" @selected( Request::get('group') == $key )>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Pangkat" name="rank" value="{{ Request::get('rank') }}">
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
