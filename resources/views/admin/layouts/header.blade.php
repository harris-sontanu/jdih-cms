<!-- Breadcrumb -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                {{ $pageHeader }}
            </h4>

            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            @isset($breadCrumbs)
                <div class="breadcrumb">
                    @foreach ($breadCrumbs as $key => $value)
                        @if ($value === TRUE)
                            <span class="breadcrumb-item active">{!! $key !!}</span>
                        @else
                            <a href="{{ $key }}" class="breadcrumb-item">{!! $value !!}</a>
                        @endif
                    @endforeach
                </div>
            @endisset

            @isset($navPills)
                <ul class="nav nav-pills">
                    @foreach ($navPills as $nav )
                        <li class="nav-item">
                            <a href="{{ $nav['route'] }}" class="nav-link @if ($nav['active']) active bg-indigo @endif">{{ $nav['text'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endisset

        </div>
    </div>
</div>
