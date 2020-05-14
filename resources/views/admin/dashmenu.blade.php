<div class="col-sm-3 sidenav">
<h4>Hoş Geldiniz {{ Auth::user()->name }}</h4>
    <hr>
    <ul class="nav flex-column nav-pills">
    <li class="nav-item"><a class="active" href="{{route("home")}}">Liste</a></li>
      <li class="nav-item"><a href="#section3">Profil Güncelle</a></li>
      <li class="nav-item"><a href="#section3">Çıkış</a></li>
    </ul>

  </div>