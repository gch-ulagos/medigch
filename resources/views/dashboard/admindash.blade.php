<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <a href="#" class="btn">Registro de Órdenes</a>
        <a href="#" class="btn">Crear Personal</a>
        <a href="#" class="btn">Editar Usuarios</a>
        <form method="POST" action="{{ route('logout') }}" id="logoutButton">
            @csrf
              <a class="nav-link active"><input type="submit" class="btn btn-danger btn-sm" id="logoutButton" value="Desconectarse"></a>
        </form>
    </div>
</body>
</html>
