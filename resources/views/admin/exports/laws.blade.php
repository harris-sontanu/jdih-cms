<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Jenis</th>
        <th>No. Peraturan</th>
        <th>Tahun</th>
        <th>Judul</th>
        <th>Singkatan Jenis</th>
        <th>Tgl. Penetapan</th>
        <th>Tgl. Pengundangan</th>
        <th>T.E.U. Badan</th>
        <th>Sumber</th>
        <th>Tempat Terbit</th>
        <th>Status</th>
        <th>Ket. Status</th>
        <th>Bidang Hukum</th>
        <th>Subjek</th>
        <th>Bahasa</th>
        <th>Lokasi</th>
        <th>Urusan Pemerintahan</th>
        <th>Penandatangan</th>
        <th>Pemrakarsa</th>
        <th>Peraturan Terkait</th>
        <th>Dokumen Terkait</th>
        <th>Operator</th>
        <th>Tgl. Posting</th>
        <th>Tgl. Terbit</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @php $i = 1; @endphp
    @foreach($laws as $law)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $law->category->name }}</td>
            <td>{{ $law->code_number }}</td>
            <td>{{ $law->year }}</td>
            <td>{{ $law->title }}</td>
            <td>{{ $law->category->abbrev }}</td>
            <td>{{ $law->dateFormatted($law->approved) }}</td>
            <td>{{ $law->dateFormatted($law->published) }}</td>
            <td>{{ $law->author }}</td>
            <td>{{ $law->source }}</td>
            <td>{{ $law->place }}</td>
            <td>{{ Str::title($law->status) }}</td>
            <td>
                <ol class="list mb-0">
                    @foreach ($law->relations()->whereType('STATUS')->get() as $relation)
                        <li>{{ Str::title($relation->status) . ' ' . $relation->relatedTo->title . ' ' . $relation->note }}</li>
                    @endforeach
                </ol>
            </td>
            <td>{{ $law->field->name ?? '-' }}</td>
            <td>{{ $law->subject }}</td>
            <td>{{ $law->language }}</td>
            <td>{{ $law->location }}</td>
            <td>{{ $law->mattersList }}</td>
            <td>{{ $law->signer }}</td>
            <td>{{ $law->institute->name ?? '-' }}</td>
            <td>
                <ol class="list mb-0">
                    @foreach ($law->relations()->whereType('LEGISLATION')->get() as $relation)
                        <li>{{ Str::title($relation->status) . ' ' . $relation->relatedTo->title . ' ' . $relation->note }}</li>
                    @endforeach
                </ol>
            </td>
            <td>
                <ol class="list mb-0">
                    @foreach ($law->relations()->whereType('DOCUMENT')->get() as $relation)
                        <li>{{ Str::title($relation->status) . ' ' . $relation->relatedTo->title . ' ' . $relation->note }}</li>
                    @endforeach
                </ol>
            </td>
            <td>{{ $law->user->name }}</td>
            <td>{{ $law->dateFormatted($law->created_at, true) }}</td>
            <td>{{ $law->dateFormatted($law->published_at, true) }}</td>
            <td>{{ $law->note }}</td>
        </tr>
        @php $i++; @endphp
    @endforeach
    </tbody>
</table>
