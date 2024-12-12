<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    <h1>Halo semua</h1>
         <form method="POST" action="{{ route('logout') }}">
                @csrf
            <button type="submit">logout </button>

        </form>
</body>
</html>