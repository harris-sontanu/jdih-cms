@if (isset($banners) AND $banners->count() > 0)
    @if ($legislations->count() > 5)
        @if ($loop->iteration === 5)
            <div class="row gx-4 mb-4">
                @foreach ($banners as $banner)
                    @break($loop->iteration > 3)
                    <div class="col-xl-4">
                        <div class="card shadow-lg bg-white border-0 lift mb-0">
                            <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif ($loop->last)
            <div class="row gx-4 mb-4">
                @foreach ($banners as $banner)
                    @continue($loop->iteration <= 3)
                    <div class="col-xl-4">
                        <div class="card shadow-lg bg-white border-0 lift mb-0">
                            <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                        </div>
                    </div>
                    @break($loop->iteration > 6)
                @endforeach
            </div>
        @endif
    @else
        @if ($loop->last)
            <div class="row gx-4 mb-4">
                @foreach ($banners as $banner)
                    @break($loop->iteration > 3)
                    <div class="col-xl-4">
                        <div class="card shadow-lg bg-white border-0 lift mb-0">
                            <a href="{{ $banner->url }}"><img src="{{ $banner->image->source }}" class="img-fluid rounded" alt="" srcset=""></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
@endif
