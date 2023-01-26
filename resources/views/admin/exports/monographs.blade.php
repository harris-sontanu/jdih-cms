<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Jenis</th>
        <th>Tahun Terbit</th>
        <th>Judul</th>
        <th>T.E.U. Orang/Badan</th>
        <th>Edisi</th>
        <th>Nomor Panggil</th>
        <th>Tempat Terbit</th>
        <th>Penerbit</th>
        <th>Deskripsi Fisik</th>
        <th>Bidang Hukum</th>
        <th>ISBN</th>
        <th>Eksemplar</th>
        <th>Subjek</th>
        <th>Bahasa</th>
        <th>Lokasi</th>
        <th>Operator</th>
        <th>Tgl. Posting</th>
        <th>Tgl. Terbit</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @php $i = 1; @endphp
    @foreach($monographs as $monograph)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $monograph->category->name }}</td>
            <td>{{ $monograph->title }}</td>
            <td>{{ $monograph->author }}</td>
            <td>{{ $monograph->edition }}</td>
            <td>{{ $monograph->call_number }}</td>
            <td>{{ $monograph->place }}</td>
            <td>{{ $monograph->publisher }}</td>
            <td>{{ $monograph->desc }}</td>
            <td>{{ $monograph->field->name ?? '-' }}</td>
            <td>{{ $monograph->isbn }}</td>
            <td>{{ $monograph->index_number }}</td>
            <td>{{ $monograph->subject }}</td>
            <td>{{ $monograph->language }}</td>
            <td>{{ $monograph->location }}</td>
            <td>{{ $monograph->user->name }}</td>
            <td>{{ $monograph->dateFormatted($monograph->created_at, true) }}</td>
            <td>{{ $monograph->dateFormatted($monograph->published_at, true) }}</td>
            <td>{{ $monograph->note }}</td>
        </tr>
        @php $i++; @endphp
    @endforeach
    </tbody>
</table>
