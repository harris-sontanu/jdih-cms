<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Jenis</th>
        <th>Tahun Terbit</th>
        <th>Judul</th>
        <th>T.E.U. Orang/Badan</th>
        <th>Tempat Terbit</th>
        <th>Sumber</th>
        <th>Bidang Hukum</th>
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
    @foreach($articles as $article)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $article->category->name }}</td>
            <td>{{ $article->year }}</td>
            <td>{{ $article->title }}</td>
            <td>{{ $article->author }}</td>
            <td>{{ $article->place }}</td>
            <td>{{ $article->source }}</td>
            <td>{{ $article->field->name ?? '-' }}</td>
            <td>{{ $article->subject }}</td>
            <td>{{ $article->language }}</td>
            <td>{{ $article->location }}</td>
            <td>{{ $article->user->name }}</td>
            <td>{{ $article->dateFormatted($article->created_at, true) }}</td>
            <td>{{ $article->dateFormatted($article->published_at, true) }}</td>
            <td>{{ $article->note }}</td>
        </tr>
        @php $i++; @endphp
    @endforeach
    </tbody>
</table>
