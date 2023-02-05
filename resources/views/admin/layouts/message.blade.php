@if (session('message'))
    <script>
        new Noty({
            theme: 'limitless',
            text: '{!! session('message') !!}',
            type: 'success',
            timeout: 2500
        }).show();
    </script>
    <div class="alert alert-success border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('message') !!}
    </div>
@elseif (session('info-message'))
    <script>
        new Noty({
            theme: 'limitless',
            text: '{!! session('info-message') !!}',
            type: 'info',
            timeout: 2500
        }).show();
    </script>
    <div class="alert alert-info border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('info-message') !!}
    </div>
@elseif (session('error-message'))
    <script>
        new Noty({
            theme: 'limitless',
            text: '{!! session('error-message') !!}',
            type: 'error',
            timeout: 2500
        }).show();
    </script>
    <div class="alert alert-danger border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! session('error-message') !!}
    </div>
@elseif (session('trash-message'))
    @php
        list($message, $action) = session('trash-message');
    @endphp
    <script>
        new Noty({
            theme: 'limitless',
            text: '{!! $message !!}',
            type: 'info',
            timeout: 2500
        }).show();
    </script>
    <div class="alert alert-info border-0 alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        {!! $message !!}
        <form action="{{ $action }}" method="post" class="d-inline-block">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-info ms-2"><i class="ph-arrow-counter-clockwise me-2"></i>Batal</button>
        </form>
    </div>
@endif
