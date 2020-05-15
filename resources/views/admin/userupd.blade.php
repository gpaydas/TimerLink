@extends('admin.dashmaster')
@section('content')
<div class="container-fluid">
    <div class="row content">

        @include('admin.dashmenu')
        <div class="col-sm-9">
            @include('layouts.errormsg')
            <h4><small>Kullanıcı Güncellemesi</small></h4>
            <hr>
            <form method="POST" action="{{route('userguncel.post')}}">
                {{csrf_field()}}
                <div class="form-group" method="POST" action="{{route('user.giris')}}>
                    <label for="exampleName">Kullanıcı Adı</label>
                    <input type="text" name="name" class="form-control" id="exampleName" aria-describedby="emailHelp"
                    value="{{ Auth::user()->name }}"
                    >
                  </div>
                <div class="form-group">
                  <label for="exampleMail">Mail Adresi</label>
                  <input type="email" name="email" class="form-control" id="exampleMail" aria-describedby="emailHelp"
                  value="{{ Auth::user()->email }}"
                  >
                </div>
                <div class="form-group">
                  <label for="examplePass">Şifre</label>
                  <input type="password" name="password" class="form-control" id="examplePass"
                  >
                </div>

                <button type="submit" class="btn btn-success">Güncelle</button>
            </form>
        </div>
    </div>
</div>
@endsection