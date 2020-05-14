<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/login.css">
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
    <body>
        <div class="sidenav" style="background-image: url('https://picsum.photos/720/1000');">
            {{-- <div class="login-main-text" >
                <h2>Application<br> Login Page</h2>
                <p>Login or register from here to access.</p>
            </div> --}}
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                    @include('layouts.errormsg')
                <form role="form" method="POST" action="{{route('user.giris')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Kullanıcı Adı</label>
                        <input type="text" name="username" class="form-control" placeholder="Kullanıcı Adı">
                    </div>
                    <div class="form-group">
                        <label>Şifre</label>
                        <input type="password" name="password" class="form-control" placeholder="Şifre">
                    </div>
                    <button type="submit" class="btn btn-black">Giriş Yap</button>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>