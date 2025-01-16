<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->email }}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
