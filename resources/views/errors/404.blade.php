@extends('layouts.master')
@section('title','404')
@section('content')
   <div class="container" style="padding-top: 10%;"">
       <div class="jumbotron text-center align-items-center">
           <h1>404</h1>
           <h2>Url Hatalı veya Süresi Bitmiş Olabilir.</h2>
           <a href="{{ route('anasayfa') }}" class="btn btn-primary">Anasayfa' ya Dön</a>
       </div>
   </div>
@endsection
