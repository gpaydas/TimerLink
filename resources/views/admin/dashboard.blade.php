@extends('admin.dashmaster')
@section('content')


<div class="container-fluid">
    <div class="row content">

        @include('admin.dashmenu')
      <div class="col-sm-9">
        <h4><small>URL LİSTESİ</small></h4>
        <hr>
        <form class="form-inline" method="POST" action="{{route('dashboard.home')}}">
            {{csrf_field()}}
            <div class="form-group mb-2-center">
                <div class="form-check form-check-inline">
                    <input name="aktif" type="checkbox" class="form-check-input" id="aktif" {{ old('aktif')=='on' ? 'checked' : '' }} >
                    <label class="form-check-label" for="aktif">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="pasif" type="checkbox" class="form-check-input" id="pasif" {{ old('pasif')=='on' ? 'checked' : '' }} >
                    <label class="form-check-label" for="pasif">Pasif</label>
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2-center">
                <label class="form-label">Sırala</label>
                <select name="siralama" class="custom-select">
                    <option value="1"{{ old('siralama')=='1' ? 'selected' : '' }} >Tıklanma (azalan)</option>
                    <option value="2" {{ old('siralama')=='2' ? 'selected' : '' }}>Tıklanma (artan)</option>
                    <option value="3" {{ old('siralama')=='3' ? 'selected' : '' }} >Yükleneme Tarihi (azalan)</option>
                    <option value="4" {{ old('siralama')=='4' ? 'selected' : '' }} >Yükleneme Tarihi (artan)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2-center">Listele</button>
          </form>

          <hr>


        <div class="row">
            <div class="container">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">IP</th>
                    <th scope="col">Kısa url</th>
                    <th scope="col">Yüklenme Tarihi</th>
                    <th scope="col">Durum</th>
                    <th scope="col">Toplam Tıklanma</th> 
                  </tr>
                </thead>
                <tbody>
                    @foreach ($sonuc as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->ipadress }}</td>
                        <td>{{ $item->short_link }}</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->durum }}</td>
                        <td>{{ $item->click_total }}</td>
                        
                      </tr>                       
                    @endforeach
                </tbody>
              </table>
              {{$sonuc->links()}}
            </div>
        </div>
      </div>
    </div>
  </div>

 @endsection