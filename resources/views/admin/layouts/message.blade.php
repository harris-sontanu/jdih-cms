@if (session('message'))
    <div class="alert alert-success border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('message') !!}
    </div>
@elseif (session('info-message'))
    <div class="alert alert-info border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('info-message') !!}
    </div>
@elseif (session('error-message'))
    <div class="alert alert-danger border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('error-message') !!}
    </div>
@elseif (session('trash-message'))
    <div class="alert alert-info border-0 alert-dismissible fade show">
        @php
            list($message, $action) = session('trash-message');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! $message !!}
        <form action="{{ $action }}" method="post" class="d-inline-block">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-info ms-2"><i class="ph-arrow-counter-clockwise me-2"></i>Batal</button>
        </form>
    </div>
@endif
