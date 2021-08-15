<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Social Media</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-200">
    <nav class="p-6 bg-white flex justify-between mb-6">
        <ul class="flex items-center">
            <li class=""><a class="p-3" href="">Home</a></li>
            <li class=""><a class="p-3" href="">Portfolio</a></li>
            <li class=""><a class="p-3" href="">Friends</a></li>
            <li class=""><a class="p-3" href="">Blog</a></li>
        </ul>
        <ul class="flex items-center">
            <li class=""><a class="p-3" href="">User's Name</a></li>
            <li class=""><a class="p-3" href="">Loagin</a></li>
            <li class=""><a class="p-3" href="">Register</a></li>
            <li class=""><a class="p-3" href="">Logout</a></li>
        </ul>
    </nav>
    @yield('content')
</body>

</html>
