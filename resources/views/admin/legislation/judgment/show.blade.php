@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <div class="card">

                    <div class="card-body">

                        <div class="row">
                            <div class="col text-center">
                                @empty($attachment)
                                    <img src="{{ asset('assets/admin/images/placeholders/file-not-found.jpg') }}" class="img-fluid rounded">
                                @else
                                    @if ($attachment->ext === 'pdf' )
                                        <figure id="adobe-dc-view" data-file="{{ $attachment->source }}" data-name="{{ $attachment->name }}" class="rounded" style="height: 720px; width: 100%;">
                                        </figure>
                                        <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
                                        <script type="text/javascript">
                                            document.addEventListener("adobe_dc_view_sdk.ready", function(){
                                            var adobeDCView = new AdobeDC.View({clientId: "{{ $adobeKey }}", divId: "adobe-dc-view"});
                                            const article = document.querySelector("#adobe-dc-view");
                                            adobeDCView.previewFile({
                                            content:{ location:
                                                { url: article.dataset.file }},
                                            metaData:{fileName: article.dataset.name}
                                            },
                                            {
                                                embedMode: "SIZED_CONTAINER"
                                            });
                                        });
                                        </script>
                                    @endif
                                @endempty
                            </div>
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="fw-semibold">Jenis Putusan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Nomor Putusan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->code_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Jenis Peradilan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->justice }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Singkatan Jenis Peradilan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->category->abbrev ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Dibacakan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->published) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">T.E.U. Badan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->author }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tempat Peradilan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->place }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Status Putusan</td>
                                            <td width="1">:</td>
                                            <td>{!! $legislation->statusBadge !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Sumber</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->source }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Bidang Hukum</td>
                                            <td width="1">:</td>
                                            <td>
                                                @empty (!$legislation->field)
                                                    <a href="{{ route('admin.legislation.judgment.index', ['field' => $legislation->field_id, 'filter' => true]) }}">{{ $legislation->field->name }}</a>
                                                @endempty
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Subjek</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->subject }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Bahasa</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->language }}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Sidebar -->
            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                <div class="sidebar-content">

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</span>
                        </div>

                        <table class="table table-borderless my-2 table-xs">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-pen me-2"></i>Status:</td>
                                    <td class="text-end">{!! $legislation->publicationBadge() !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                    <td class="text-end">{{ $legislation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Posting:</td>
                                    <td class="text-end">
                                        <abbr class="publish-date-text" data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->created_at, true) }}">{{ $legislation->dateFormatted($legislation->created_at) }}</abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Terbit:</td>
                                    <td class="text-end">
                                        <abbr class="publish-date-text" data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->published_at, true) }}">{{ $legislation->dateFormatted($legislation->published_at) }}</abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-eye me-2"></i>Dilihat:</td>
                                    <td class="text-end">{{ $legislation->view }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap"><i class="ph-file-arrow-down me-2"></i>Diunduh:</td>
                                    <td class="text-end">{{ $legislation->documents->sum('download') }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold"><i class="ph-file-text me-2"></i>Lampiran</span>
                        </div>

                        <div class="sidebar-section-body pb-0">
                            @if ($attachment)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-2">
                                        <i class="{{ $attachment->extClass; }} ph-2x"></i>
                                    </div>

                                    <div class="flex-fill overflow-hidden">
                                        <a href="{{ $attachment->source }}" class="fw-semibold text-body text-truncate" target="_blank">{{ $attachment->name; }}</a>
                                        <ul class="list-inline list-inline-bullet fs-sm text-muted mb-0">
                                            <li class="list-inline-item me-1">{{ $attachment->typeTranslate }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <p class="mb-3">Tidak ada dokumen lampiran</p>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <h5 class="mb-0"><i class="ph-clock-counter-clockwise me-2"></i>Riwayat</h5>
                        </div>

                        <div class="sidebar-section-body media-chat-scrollable">
                            <div class="list-feed">
                                @forelse ($legislation->logs->take(10) as $log)
                                    <div class="list-feed-item">
                                        <span class="fw-semibold">{{ $log->user->name }}</span> {!! $log->message !!}
                                        <div class="text-muted fs-sm">{{ $log->timeDifference($log->created_at) }}</div>
                                    </div>
                                @empty
                                    <p class="mb-0">Belum ada riwayat</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /sidebar content -->

            </div>
            <!-- /sidebar -->

        </div>

    </div>
    <!-- /content area -->

@endsection
