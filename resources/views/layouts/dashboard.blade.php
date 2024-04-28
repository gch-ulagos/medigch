<!DOCTYPE html>
<html lang="en">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
  </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGCH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}">
</head>
<body>
    <header>
      <img src="{{ URL::asset('images/MediGCH.png') }}" alt="Logo">
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
        <img src="{{ URL::asset('images/banner.png') }}" alt="banner image" class="banner-image">
        <div class="banner-text">Bienvenido, {{Auth::user()->name}}</div>
      </div>
      <div class="container">
        <section id="documents">
          @yield('content')
        </section>
        <section id='display'>
          @yield('display')
        </section>
      </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>