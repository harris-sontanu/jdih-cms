<div class="card m-0">

    <div class="card-body text-center bg-purple card-img-top text-white @if (Route::currentRouteName() == 'admin.employee.show') rounded-0 @endif" style="background-image: url(/assets/admin/images/backgrounds/panel_bg.png); background-size: contain;">
        <div class="card-img-actions d-inline-block mb-3">
            <img class="img-fluid rounded-circle" src="{{ $employee->pictureThumbUrl }}" alt="{{ $employee->name }}" width="170" height="170">
        </div>

        <h6 class="font-weight-bold mb-0">{{ $employee->name }}</h6>
        @if ($employee->nip)
            <span class="d-block opacity-75">NIP: {{ $employee->nip }}</span>
        @endif

        @if (!empty($employee->facebook) OR !empty($employee->twitter) OR !empty($employee->instagram) OR !empty($employee->tiktok) OR !empty($employee->youtube))
            <ul class="list-inline list-inline-condensed mt-3 mb-0">

                @if (!empty($employee->facebook))
                    <li class="list-inline-item">
                        <a href="{{ $employee->facebook }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                            <i class="ph-facebook-logo"></i>
                        </a>
                    </li>
                @endif

                @if (!empty($employee->twitter))
                    <li class="list-inline-item">
                        <a href="{{ $employee->twitter }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                            <i class="ph-twitter-logo"></i>
                        </a>
                    </li>
                @endif

                @if (!empty($employee->instagram))
                    <li class="list-inline-item">
                        <a href="{{ $employee->instagram }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                            <i class="ph-instagram-logo"></i>
                        </a>
                    </li>
                @endif

                @if (!empty($employee->tiktok))
                    <li class="list-inline-item">
                        <a href="{{ $employee->tiktok }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                            <i class="ph-tiktok-logo"></i>
                        </a>
                    </li>
                @endif

                @if (!empty($employee->youtube))
                    <li class="list-inline-item">
                        <a href="{{ $employee->youtube }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                            <i class="ph-youtube-logo"></i>
                        </a>
                    </li>
                @endif
            </ul>
        @endif

    </div>

    <div class="card-body border-top-0">

        @if (!empty($employee->bio))
            <h5 class="fw-bold text-center">Biografi</h5>
            <p>{{ $employee->bio }}</p>
        @endif

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Nama:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->name }}</div>
        </div>

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Jabatan:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->position }}</div>
        </div>

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Pangkat:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->rank }}</div>
        </div>

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Grup:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">
                @foreach ($employee->groups as $group)
                    <span class="badge bg-light border-start border-width-3 text-body rounded-start-0 border-{{ $group->class }}">{{ $group->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Email:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->email }}</div>
        </div>

        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="fw-semibold">Telepon:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->phone }}</div>
        </div>

        <div class="d-sm-flex flex-sm-wrap">
            <div class="fw-semibold">Alamat:</div>
            <div class="ms-sm-auto mt-2 mt-sm-0">{{ $employee->fullAddress }}</div>
        </div>

    </div>

</div>
