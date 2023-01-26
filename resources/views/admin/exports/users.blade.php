<table>
    <thead>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Website</th>
        <th>Level</th>
        <th>Status</th>
        <th>Login Terakhir</th>
        <th>Terdaftar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->website }}</td>
            <td>{{ Str::ucfirst($user->role) }}</td>
            <td>{{ Str::ucfirst($user->status()) }}</td>
            <td>{{ $user->dateFormatted($user->last_logged_in_at) }}</td>
            <td>{{ $user->dateFormatted($user->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
