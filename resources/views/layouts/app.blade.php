<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Social Media</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-400">
    <nav class="p-6 bg-white flex justify-between">
        <ul>
            <li><a href="">Home</a></li>
            <li><a href="">Portfolio</a></li>
            <li><a href="">Friends</a></li>
            <li><a href="">Blog</a></li>
        </ul>
    </nav>
    @yield('content')
</body>

</html>
