<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes User</title>
</head>
<body>
    <h1> Ini Dashboard User</h1>
     @can('is-authenticated')
        <form method="POST" action="{{ route('logout') }}">
                @csrf

            <button type="submit">logout </button>

        </form>
     @endcan
    @can('is-admin')
    <h1>ini admin kamu tidak bisa lihat</h1>
    @endcan

</body>
</html>
