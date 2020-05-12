@extends('layouts.master')
@section('title','Anasayfa')
@section('content')
<div class="limiter">
    <div class="container-form100">
        <div class="form100-more" style="background-image: url('https://picsum.photos/720/1000');"></div>

        <div class="wrap-form100 p-l-50 p-r-50 p-t-72 p-b-50">
            <div id="content"></div>
            <form class="form100-form validate-form" method="POST" action="{{route('url.kaydol')}}">
                {{csrf_field()}}
                <span class="form100-form-title p-b-59">
                    Zamanlı Url
                </span>

                <div class="wrap-input100">
                    <span class="label-input100">Url</span>
                    <input class="input100" name="long_link" id="long_link" placeholder="Url giriniz...">
                    <span class="focus-input100"></span>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="wrap-input100">
                            <span class="label-input100 border-0">Süre Tipi</span>
                            <select class="input100" name="period_type"  id="period_type">
                                <option value="1">Dakika</option>
                                <option value="60">Saat</option>
                                <option value="3600">Gün</option>
                            </select>
                            <span class="focus-input100"></span>
                        </div> 
                    </div>
                    <div class="col-sm">
                        <div class="wrap-input100">
                            <span class="label-input100">Süre Giriniz</span>
                            <input class="input100" name="period" id="period" placeholder="Süre Giriniz...">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                </div>
                    <div class="container-form100-form-btn">
                        <div class="wrap-form100-form-btn">
                            <div class="form100-form-bgbtn"></div>
                            {{-- <button type="submit" class="form100-form-btn">
                                Dönüştür
                            </button> --}}

                            <a href="#"
                            class="form100-form-btn donustur"
                         >Dönüştür</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
 
</div>
	
@endsection


@section('footer')
    <script>
        $(function () {
            $('.donustur').on('click', function () {
                var long_link = $("#long_link").val();
                var period = $("#period").val();
                var period_type = $("#period_type").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('url.kaydol')}}",
                    data: {long_link: long_link, period: period,period_type:period_type},
                    success: function(result) {

                        document.getElementById("content").innerHTML = 
                        '<div class="container">'+
                        '<div class="alert alert-success" role="alert">'+
                        '<h4 class="alert-heading">İşlem Başarılı!</h4>'+ 
                        '<hr>'+
                        '<input class="input100" type="text" value="'+result.msj+'" id="myInput">'+
                        '<button class="btn btn-success" onclick="CopyFunction()">Kopyala</button>'+
                        '</div>'+
                        '</div>';
                    },
                    error: function(xhr, status, text) {
                        var errorObj = xhr.responseJSON; 
                        document.getElementById("content").innerHTML = 
                        '<div class="container">'+
                        '<div class="alert alert-danger" role="alert">'+
                        '<h4 class="alert-heading">Hata!</h4>'+ 
                        '<hr>'+
                        '<p> '+errorObj.msj+'</p>'+
                        '</div>'+
                        '</div>';
                    }
                })
            })
        });
    </script>
    <script>
    function CopyFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        document.execCommand("copy");
        alert("Kopyalanan Veri: " + copyText.value);
        //alert2
        }
    </script>
@endsection

