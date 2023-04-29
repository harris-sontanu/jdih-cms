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

                        <h4 class="card-title">{{ $legislation->title }}</h4>

                        <div class="row">
                            <div class="col">
                                @empty($masterDoc)
                                    <img src="{{ asset('assets/admin/images/placeholders/placeholder.jpg') }}" class="img-fluid rounded">
                                @else
                                    @if ($masterDoc->media->ext === 'pdf' )
                                        <figure id="adobe-dc-view" data-file="{{ $masterDoc->media->source }}" data-name="{{ $masterDoc->media->name }}" class="rounded" style="height: 720px; width: 100%;">
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

                                @isset($legislation->note)
                                    <div class="mt-4">
                                        <h5>Catatan</h5>

                                        <p>{{ $legislation->note }}</p>
                                    </div>
                                @endisset
                            </div>
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="fw-semibold">Jenis Peraturan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Nomor</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->code_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tahun Terbit</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->year }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Singkatan Jenis</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->category->abbrev }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Penetapan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->approved) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Pengundangan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->published) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">T.E.U. Badan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->author }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Sumber</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->source }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tempat Terbit</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->place }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Status</td>
                                            <td width="1">:</td>
                                            <td>{!! $legislation->status->badge() !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Bidang Hukum</td>
                                            <td width="1">:</td>
                                            <td>
                                                @empty (!$legislation->field)
                                                    <a href="{{ route('admin.legislation.law.index', ['field' => $legislation->field_id, 'filter' => true]) }}">{{ $legislation->field->name }}</a>
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
                                        <tr>
                                            <td class="fw-semibold">Lokasi</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->location }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Urusan Pemerintahan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->mattersList }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Penandatangan</td>
                                            <td width="1">:</td>
                                            <td>{{ $legislation->signer }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Pemrakarsa</td>
                                            <td width="1">:</td>
                                            <td>
                                                @empty (!$legislation->institute)
                                                    <a href="{{ route('admin.legislation.law.index', ['institute' => $legislation->institute_id, 'filter' => true]) }}">{{ $legislation->institute->name }}</a>
                                                @endempty
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                @if (isset($relationships) AND $relationships->byType('status')->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Keterangan Status</h4>
                        </div>
                        <div class="card-body">
                            <ol class="list mb-0">
                                @foreach ($relationships->byType('status') as $relation)
                                    <li>{{ $relation->status->label() }} <a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank">{{ $relation->relatedTo->title }}</a> {{ $relation->note }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif

                @if (isset($relationships) AND $relationships->byType('legislation')->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Peraturan Terkait</h4>
                        </div>
                        <div class="card-body">
                            <ol class="list mb-0">
                                @foreach ($relationships->byType('legislation') as $relation)
                                    <li>{{ $relation->status->label() }} <a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank">{{ $relation->relatedTo->title }}</a> {{ $relation->note }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif

                @if (isset($relationships) AND $relationships->byType('document')->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Dokumen Terkait</h4>
                        </div>
                        <div class="card-body">
                            <ol class="list mb-0">
                                @foreach ($relationships->byType('document') as $relation)
                                    <li><a href="{{ route('admin.legislation.law.show', $relation->related_to) }}" target="_blank">{{ $relation->relatedTo->title }}</a> {{ $relation->note }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif

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

                        @can('update', $legislation)
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <a href="{{ route('admin.legislation.law.edit', $legislation->id) }}" class="btn btn-indigo">Ubah</a>
                            </div>
                        @endcan

                    </div>

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold"><i class="ph-files me-2"></i>Dokumen</span>
                        </div>

                        <div class="sidebar-section-body pb-0">
                            @if ($legislation->documents->count() > 0)
                                @foreach ($legislation->documents as $document)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="me-2">
                                            <i class="{{ $document->media->extClass; }} ph-2x"></i>
                                        </div>

                                        <div class="flex-fill overflow-hidden">
                                            <a href="{{ $document->media->mediaUrl }}" class="fw-semibold text-body text-truncate" target="_blank">{{ $document->media->name; }}</a>
                                            <ul class="list-inline list-inline-bullet fs-sm text-muted mb-0">
                                                <li class="list-inline-item me-1">{{ $document->type->label() }}</li>
                                                <li class="list-inline-item ms-1">{{ $document->media->size() }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="mb-3">Tidak ada dokumen</p>
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
