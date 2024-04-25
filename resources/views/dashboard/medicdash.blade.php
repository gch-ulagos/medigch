<!DOCTYPE html>
<html lang="en">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
  </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGCH</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
      <img src="images/MediGCH.png" alt="Logo">
        <nav>
            <ul>
                <li><a href="#">Mi Perfil</a></li>
                <form method="POST" action="{{ route('logout') }}" id="logoutButton">
                  @csrf
                    <a class="nav-link active"><input type="submit" class="btn btn-danger btn-sm" id="logoutButton" value="Desconectarse"></a>
              </form>
            </ul>
        </nav>
    </header>
    <main>
      <div class="banner">
        <img src="images/banner.png" alt="banner image" class="banner-image">
        <div class="banner-text">Bienvenido, usuario</div>
      </div>
      <div class="container">
        <section id="documents">
            <h2>Órdenes</h2>
            <p>Revisa tus órdeness</p>
            <div class="frame-container">
              <div class="frame">
                <h3>Ingresar órden</h3>
              </div>
              <div class="frame">
                <h3>Revisar historial de órdenes</h3>
              </div>
            </div>
        </section>
    </main>
  <footer class="main-footer"></footer>
</body>
</html>