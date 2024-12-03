<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
</head>

<body>
    <h1>{{ $title }}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawan as $k)
                <tr>
                    <td>{{ $k['nama'] }}</td>
                    <td>{{ $k['jabatan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
