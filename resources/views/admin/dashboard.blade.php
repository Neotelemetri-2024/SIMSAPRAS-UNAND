<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>
</head>
<body>
    <h1> Ini Dashboard Super Admin, Admin , Pimpinan</h1>
     <form method="POST" action="{{ route('logout') }}">
                @csrf
            <button type="submit">logout </button>

        </form>
    
</body>
</html>