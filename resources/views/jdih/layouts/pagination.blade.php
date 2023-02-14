@if ($paginator->hasPages())

<tfoot>
    <tr>
        <td colspan="100">
            <nav class="d-flex justify-items-center justify-content-center pt-3 mb-3">
                <div class="d-flex justify-content-between flex-fill d-sm-none">
                    <ul class="pagination pagination-flat">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link rounded-pill">@lang('pagination.previous')</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <a class="page-link rounded-pill" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link rounded-pill">@lang('pagination.next')</span>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-center">

                    <div>
                        <ul class="pagination pagination-flat">
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span class="page-link rounded-pill" aria-hidden="true"><i class="ph-arrow-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="ph-arrow-left"></i></a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link rounded-pill">{{ $element }}</span></li>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                            <li class="page-item active" aria-current="page"><span class="page-link rounded-pill">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link rounded-pill" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded-pill" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="ph-arrow-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span class="page-link rounded-pill" aria-hidden="true"><i class="ph-arrow-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </td>
    </tr>
</tfoot>

@endif
