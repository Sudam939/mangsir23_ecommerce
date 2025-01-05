<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .body{
            background-color: rgb(84, 143, 84);
            border-radius: 30px;
            padding: 20px;
            width: 75%;
            margin: auto;
            color: white;
        }

        .body h1{
            font-size: 26px;
        }

        .body p{
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="body">
        <h1>Dear {{ $data['to'] }},</h1>
        <p>{{ $data['message'] }}</p>
        <footer>
            Regards,
        </footer>
    </div>

</body>

</html>
