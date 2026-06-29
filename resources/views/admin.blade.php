<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DEMAR</title>
</head>
<body>
    <h1>Panel de administrador</h1>
    <p>Bienvenido, administrador.</p>

    <form method="POST" action="{{ route('cajero.logout.post') }}">
        @csrf
        <button type="submit">Cerrar sesi&oacute;n</button>
    </form>
</body>
</html>
