@if (session('message'))
<script>
    new Noty({
        theme: 'limitless',
        text: "{!! session('message') !!}",
        type: 'success',
        timeout: 2500
    }).show();
</script>
@elseif (session('info-message'))
<script>
    new Noty({
        theme: 'limitless',
        text: "{!! session('info-message') !!}",
        type: 'info',
        timeout: 2500
    }).show();
</script>
@elseif (session('error-message'))
<script>
    new Noty({
        theme: 'limitless',
        text: "{!! session('error-message') !!}",
        type: 'error',
        timeout: 2500
    }).show();
</script>
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
