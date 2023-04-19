<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Jenis</th>
        <th>Nomor Putusan</th>
        <th>Judul</th>
        <th>Jenis Peradilan</th>
        <th>Singkatan Jenis Peradilan</th>
        <th>Tgl. Dibacakan</th>
        <th>T.E.U. Badan</th>
        <th>Tempat Peradilan</th>
        <th>Status Putusan</th>
        <th>Sumber</th>
        <th>Bidang Hukum</th>
        <th>Subjek</th>
        <th>Bahasa</th>
        <th>Operator</th>
        <th>Tgl. Posting</th>
        <th>Tgl. Terbit</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @php $i = 1; @endphp
    @foreach($judgments as $judgment)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $judgment->category->name }}</td>
            <td>{{ $judgment->code_number }}</td>
            <td>{{ $judgment->title }}</td>
            <td>{{ $judgment->justice }}</td>
            <td>{{ $judgment->category->abbrev ?? '-' }}</td>
            <td>{{ $judgment->dateFormatted($judgment->published) }}</td>
            <td>{{ $judgment->author }}</td>
            <td>{{ $judgment->place }}</td>
            <td>{{ Str::title($judgment->status) }}</td>
            <td>{{ $judgment->source }}</td>
            <td>{{ $judgment->field->name ?? '-' }}</td>
            <td>{{ $judgment->subject }}</td>
            <td>{{ $judgment->language }}</td>
            <td>{{ $judgment->user->name }}</td>
            <td>{{ $judgment->dateFormatted($judgment->created_at, true) }}</td>
            <td>{{ $judgment->dateFormatted($judgment->published_at, true) }}</td>
            <td>{{ $judgment->note }}</td>
        </tr>
        @php $i++; @endphp
    @endforeach
    </tbody>
</table>
