<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGCH</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
    }
    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Dashboard</h1>
    <a href="mis_ordenes.html" class="btn">Mis Órdenes</a>
    <a href="mi_perfil.html" class="btn">Mi Perfil</a>
    <button class="btn" onclick="desconectar()">Desconectarse</button>
  </div>

  <script>
    function desconectar() {
      // Aquí puedes agregar la lógica para desconectar al usuario
      alert("Desconectando...");
    }
  </script>
</body>
</html>
